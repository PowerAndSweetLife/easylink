<?php

namespace App\Http\Controllers\MadaAgent;

use App\Helper\Dimension;
use App\Helper\Facture as HelperFacture;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Client;
use App\Models\Colis;
use App\Models\Facture;
use App\Models\FactureHistory;
use App\Models\Metadata;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FacturationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status') ?? 'not-paid';
        $filter = false;
        if($status === 'paid')
        {
            $filter = true;
        }
        $lists = null;
        $query = Facture::join('bookings', 'bookings.id', '=', 'factures.booking_id')
                        ->join('clients', 'clients.id', 'bookings.client_id')
                        ->select('factures.*')
                        ->with('booking')
                        ->where('is_paid', $filter);
        $uid = $request->input('uid');
        if($uid)
        {
            $query->where('uid', '=', $uid);
        }
        $lists = $query->paginate(env('PER_PAGE'));
        $lists->appends([
            'active' => $status,
            'uid' => $uid
        ]);
        return view('mada-agent.facturation', [
            'lists' => $lists,
            'active' => $status,
            'uid' => $uid
        ]);
    }

    public function edit(int $id)
    {
        $data = Facture::with('booking')
                    ->where('id', $id)
                    ->get()->first();
        return view('mada-agent.facture-edit', [
            'data' => $data,
            'categories' => Category::all()
        ]);
    }
    public function update(Request $request, int $factureId)
    {

        $listsId = $request->input('id');
        $dimensions = $request->input('dimensions');
        $categories = $request->input('categories');

        foreach($listsId as $id)
        {
            $dimension = Dimension::encode($dimensions[$id]);
            $colis = Colis::find($id);
            $colis->update([
                'description' => (int)$categories[$id],
                'dimensions' => $dimension
            ]);
        }

        $facture = Facture::find($factureId);
        $booking = Booking::with('manifest')->with('colis')->where('id', $facture->booking_id)->get()->first();
        // $expeditions = Expedition::with('colis')->where('booking_id', $facture->booking_id)->get();

        $price = HelperFacture::price($booking, $booking->manifest?->bmoi_rate);

        // dd($price);

        $facture->update([
            'amount' => $price->foreign,
            'amount_ariary' => $price->ariary,
            'storage_fee' => $price->storage_price ,
        ]);
        
        return redirect(route('mada-agent.facturation.index'))->with('success', true);
    }

    public function pay(int $id)
    {
        return view('mada-agent.facture-pay', [
            'data' => Facture::with('booking')
                            ->where('id', $id)
                            ->get()->first()
        ]);
    }

    public function doPay(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|gt:0',
            'method_payment' => 'required',
            'reference_payment' => 'required'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $facture = Facture::findOrFail($id);


        $total = (float)$facture->amount_ariary;
        $rest = (float)$facture->rest;
        $amount = (float)$request->input('amount');

        $restToPay = 0;
        if($rest > 0)
        {
            $restToPay = $rest - $amount;
        }
        else
        {
            $restToPay = $total - $amount;
        }

        $paid = (float)$facture->amount_paid + $amount;
        $isPaid = 0;
        if($restToPay <= 0)
        {
            $restToPay = 0;
            $isPaid = 1;
        }

        $facture->update([
            'amount_paid' => $paid,
            'rest' => $restToPay,
            'is_paid' => $isPaid
        ]);

        FactureHistory::create([
            'facture_id' => $facture->id,
            'to_paid' => $rest > 0 ? $rest : $total,
            'paid' => $amount,
            'rest' => $restToPay,
            'method_payment' => $request->input('method_payment'),
            'reference_payment' => $request->input('reference_payment'),
            'date_paiement' => new DateTime()
        ]);

        return redirect(route('mada-agent.facturation.index'))->with('success', true);

    }

    public function history(int $id)
    {
        // dd(FactureHistory::where('facture_id', $id)->get()) ;
        return view('mada-agent.facture-history', [
            'lists' => FactureHistory::where('facture_id', $id)->get()
        ]);
    }

    public function print(int $id)
    {
        // dd($id) ;
        $facture = FactureHistory::with('facture')->where('id', $id)->get()->first();
        // dd($facture) ;
        if(!$facture)
        {
            echo "Impression impossible, Facture introuvable";
            return null;
        }

        $clientCount = Client::count();
        $categories = Category::all();
        $cbmConfig = Metadata::where('key', 'cbm_min');

        
        $pdf = Pdf::loadView('mada-agent.facture-pdf', [
                    'item' => $facture, 
                    "clientCount" => $clientCount, 
                    'categories' => $categories,
                    'cbmConfig' => $cbmConfig
                ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
