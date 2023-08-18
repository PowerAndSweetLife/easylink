<?php

namespace App\Http\Controllers\Agent;

use App\Helper\Dimension;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Colis;
use App\Models\Facture;
use App\Models\Metadata;
use App\Models\Notification;
use DateTime;
use Illuminate\Http\Request;

class ExpeditionController extends Controller
{
    public function colisList(Request $request, string $status)
    {
        if(!in_array($status, ['received', 'not-received']))
        {
            return redirect()->route('agent.colis.list', ['status' => 'not-received'], 301);
        }

        $urlQueryString = $request->input('query');
        
        $qb = Colis::with('client')
                ->with('category')
                ->where('agent_id', $request->session()->get('agent')['id']);
        if($status === 'not-received')
        {
            $qb->whereNull('booking_id');
            $qb->orderBy('send_at', 'desc');
        }
        else
        {
            $qb->whereNotNull('booking_id');
            $qb->orderBy('receive_at', 'desc');
        }
        
        if(!is_null($urlQueryString))
        {
            if($status === 'received')
            {
                $qb->where(function($builder) use($urlQueryString) {
                    $builder->where('shiporder',"$urlQueryString")
                            ->orWhere('receip_number', $urlQueryString);
                });
            }
            else
            {
                $qb->where('receip_number', $urlQueryString);
            }
        }

        $lists = $qb->paginate(env('PER_PAGE'));
        $lists->appends("query", $urlQueryString);
        
        return view('agent.colis-list',[
            "lists" => $lists,
            "active" => $status,
            "query" => $urlQueryString
        ]);
    }

    public function receiveColis(Request $request)
    {
        $reference = $this->_shipAndBookingColis($request, $request->input('colis-id'));
        return redirect(route('agent.colis.list', ['status' => 'not-received']))
                    ->with('success', true)
                    ->with('successMessage', __('Package well received.') . " Shiporder: $reference->shiporder - Booking: $reference->booking");
    }

    public function receiveMoreColis(Request $request)
    {
        foreach($request->input('id-list') as $colisId)
        {
            $this->_shipAndBookingColis($request, $colisId);
        }
        return redirect(route('agent.colis.list', ['status' => 'not-received']))->with('success', true)
                        ->with('successMessage', __('Selected packages well received.'));
    }

    public function showColis(Request $request, int $id)
    {
        $colis = Colis::findOrFail($id);
        return view('agent.colis-detail', [
            'colis' => $colis
        ]);
    }

    public function editColis(int $id)
    {
        $colis = Colis::findOrFail($id);
        if($colis->status !== Colis::SEND)
        {
            return redirect(route('agent.colis.list', ['status' => 'not-received']));
        }
        return view('agent.colis-edit', [
            'categories' => Category::all(),
            'colis' => $colis
        ]);
    }

    public function updateColis(Request $request, int $id)
    {
        $colis = Colis::findOrFail($id);
        $dimensions = $request->input('dimensions');
        $colis->category_id = $request->input('category_id');
        $colis->description = $request->input('description');
        $colis->dimensions = Dimension::encode($dimensions);

        $notification = new Notification();
        $notification->colis_id = $id;
        // $notification->original = 
        $notification->client_id = $colis->client_id;
        $notification->agent_id = $request->session()->get('agent')['id'];

        $colis->save();
        $this->_shipAndBookingColis($request, $id);
        return redirect(route('agent.colis.list', ['status' => 'not-received']))
                        ->with('success', true)
                        ->with('successMessage', "Package has been successfully modified");
    }

    public function notReceived(Request $request)
    {
        $id = (int)$request->input('colis-id');
        $colis = Colis::findOrFail($id);

        $colis->update([
            "shiporder" => str_replace("S", "T", $colis->shiporder),
            "status" => Colis::SEND,
            "booking_id" => null,
            "receive_at" => null
        ]);
        return redirect(route('agent.colis.list', ['status' => 'not-received']));
    }

    private function _shipAndBookingColis(Request $request, int $colisId): object
    {
        /** @var Colis */
        $colis = Colis::where('id', $colisId)->get()->first();

        /**
         * Mise à jour colis
         */
        $colis->shiporder = str_replace("T", "S", $colis->shiporder);
        $colis->receive_at = new DateTime();
        $colis->status = Colis::RECEIVED;

        /**
         * Ajouter l'expedition au booking ouvert
         */
        $openBooking = Booking::where('client_id', $colis->client_id)
                            ->where('agent_id', $request->session()->get('agent')['id'])
                            ->where('is_open', true)
                            ->get()
                            ->first();
        if(is_null($openBooking))
        {
            $openBooking = Booking::create([
                "reference" => $this->_generateBookingReference(),
                "client_id" => $colis->client_id,
                "agent_id" => $request->session()->get('agent')['id']
            ]);

            /**
             * Generer facture
             */
            Facture::create([
                "booking_id" => $openBooking->id
            ]);

        }

        $colis->booking_id = $openBooking->id;
        if($openBooking->manifest_id !== null)
        {
            $colis->status = Colis::ONBOARD;
        }

        $colis->save();

        return (object)[
            'shiporder' => $colis->shiporder,
            'booking' => $openBooking->reference
        ];
    }


    private function _generateBookingReference(): string
    {
        $current = Metadata::where('key', date('Y') . '_last_booking_ref')->get()->first();
        $new = null;
        if(is_null($current))
        {
            $new = 1;
            $metadata = new Metadata([
                'key' => date('Y') . '_last_booking_ref',
                'value' => 1
            ]);
            $metadata->save();
        }
        else
        {
            $new = (int)$current->value + 1;
            $current->value = $new;
            $current->save();
        }

        return "B" . date('y') . str_pad($new, 4, "0", STR_PAD_LEFT);
    }
}
