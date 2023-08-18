<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Colis;
use App\Models\Manifest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $lists = Booking::with('client')
                    ->whereNull('manifest_id')
                    ->paginate(env('PER_PAGE'));
        $manifests = Manifest::join('containers', 'containers.id', 'manifests.container_id')
                            ->select('manifests.*')
                            ->with('container')
                            ->with('booking')
                            ->where('manifests.agent_id', $request->session()->get('agent')['id'])
                            ->where('containers.is_available', true)
                            ->get();
        return view('agent.booking', [
            'lists' => $lists,
            'manifests' => $manifests
        ]);
    }

    public function show(int $id)
    {
        $booking = Booking::with('colis')
                        ->with('client')
                        ->where('id', $id)
                        ->get()
                        ->first();
        return view('agent.modal.package-lists-content', [
            'booking' => $booking
        ]);
    }

    public function addToContainer(Request $request)
    {
        $manifestId = $request->input('manifest-id');
        $bookingId = $request->input('booking-id');

        if(is_null($manifestId))
        {
            return redirect(route('agent.booking.index'));
        }


        $booking = Booking::find($bookingId);
        $booking->manifest_id = $manifestId;
        $booking->cob = new DateTime();
        $booking->save();

        /**
         * Update status colis
         */
        DB::table('colis')
              ->where('booking_id', $bookingId)
              ->update(['status' => Colis::ONBOARD]);

        return redirect(route('agent.booking.index'))
                        ->with('success', true)
                        ->with('successMessage', 'Booking added to container');
    }

    public function addMoreToContainer(Request $request)
    {
        $manifestId = $request->input('manifest-id');
        $bookingsId = $request->input('id-list');
        if(is_null($manifestId))
        {
            return redirect(route('agent.booking.index'));
        }

        /**
         * Add manifest_id booking 
         */
        DB::table('bookings')
              ->whereIn('id', $bookingsId)
              ->update(['manifest_id' => $manifestId, 'cob' => new DateTime()]);

        foreach ($bookingsId as $bookingId) 
        {   
            /**
             * Update status colis
             */
            DB::table('colis')
                ->where('booking_id', $bookingId)
                ->update(['status' => Colis::ONBOARD]);
        }
        return redirect(route('agent.booking.index'))->with('success', true)
                        ->with('successMessage', 'Booking added to container');
    }

    /**
     * Enlever un colis|shiporder du booking
     */
    public function removeColis(int $id)
    {
        $colis = Colis::findOrFail($id);
        $bookingId = $colis->booking_id;
        $colis->shiporder = str_replace("S", "T", $colis->shiporder);
        $colis->status = Colis::SEND;
        $colis->receive_at = null;
        $colis->booking_id = null;
        $colis->save();

        return $this->show($bookingId);
    }

}
