<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Facture;
use App\Models\FactureHistory;
use App\Models\Metadata;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        return view('client.facture', [
            'lists' => Facture::join('bookings', 'bookings.id','=', 'factures.booking_id')
                            // ->select('factures.*')
                            ->where('client_id', $request->session()->get('client')['id'])
                            ->whereNotNull('amount')
                            ->orderBy('is_paid', 'ASC')
                            ->paginate(env('PER_PAGE'))
        ]);
    }

    public function history(int $id, Request $request)
    {
        // dd($id) ;
        $facture = Facture::join('bookings', 'bookings.id','=', 'factures.booking_id')
                        ->select('factures.*')
                        ->where('client_id', $request->session()->get('client')['id'])
                        ->where('factures.id', $id)
                        ->get()->first();
        
        
        if(is_null($facture))
        {
            return redirect(route('client.facture.index'));
        }
        return view('client.facture-history', [
            'lists' => FactureHistory::where('facture_id', $id)->get()
        ]);
    }
    public function print(int $id, Request $request)
    {
        
        $facture = Facture::join('bookings', 'bookings.id','=', 'factures.booking_id')
                        ->select('factures.*')
                        ->where('client_id', $request->session()->get('client')['id'])
                        // ->where('factures.id', $id)
                        ->get()->first();
        // dd($facture) ;                
        if(is_null($facture))
        {
            return redirect(route('client.facture.index'));
        }

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

        
        $pdf = Pdf::loadView('admin.facture-pdf', [
                    'item' => $facture, 
                    "clientCount" => $clientCount, 
                    'categories' => $categories,
                    'cbmConfig' => $cbmConfig
                ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
