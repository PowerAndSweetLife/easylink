<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Dimension;
use App\Helper\Facture as HelperFacture;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Client;
use App\Models\Colis;
use App\Models\Expedition;
use App\Models\Facture;
use App\Models\FactureHistory;
use App\Models\Metadata;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;

class FactureController extends Controller
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
        return view('admin.facturation', [
            'lists' => $lists,
            'active' => $status,
            'uid' => $uid
        ]);
    }

    public function history(int $id)
    {
        return view('admin.facture-history', [
            'lists' => FactureHistory::where('facture_id', $id)->get()
        ]);
    }

    public function print(int $id)
    {
        $facture = FactureHistory::with('facture')->where('id', $id)->get()->first();
        
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
