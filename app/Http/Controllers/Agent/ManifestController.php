<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Colis;
use App\Models\Container;
use App\Models\Manifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManifestController extends Controller
{
    public function index()
    {
        return view('agent.manifest', [
            'lists' => Manifest::join('containers', 'manifests.container_id', '=', 'containers.id')
                            ->select('manifests.*')
                            ->with('container')
                            ->with('booking')
                            ->where('containers.is_available', true)
                            ->get()
        ]);
    }

    public function send(Request $request)
    {
        $containerId = $request->input('container-id');
        $container = Container::find($containerId);
        $manifest = Manifest::with('booking')->where('container_id', $containerId)->get()->first();

        $manifest->status = Colis::FLOATING;
        $manifest->save();

        $container->is_available = false;
        $container->save();

        /**
         * Close booking
         */
        DB::table('bookings')
            ->where('manifest_id', $manifest->id)
            ->update(['is_open' => false]);
        /**
         * Update status colis
         */
        foreach($manifest->booking as $booking)
        {
            DB::table('colis')
                ->where('booking_id', $booking->id)
                ->update(['status' => Colis::FLOATING]);
        }
        return redirect(route('agent.manifest.index'))->with('success', true)
                        ->with('successMessage', 'Container sended successfully');
    }

    public function show(int $id)
    {
        return view('agent.modal.booking-lists-content', [
            'manifest' => Manifest::with("container")
                            ->with('booking')
                            ->where('id', $id)
                            ->get()
                            ->first()
        ]);
    }

    public function removeBooking(int $id)
    {
        $booking = Booking::findOrFail($id);
        $manifestId = $booking->manifest_id;
        $booking->cob = null;
        $booking->manifest_id = null;
        $booking->save();

        DB::table('colis')->where('booking_id', $id)->update([
            'status' => Colis::RECEIVED
        ]);
        return $this->show($manifestId);
    }

}
