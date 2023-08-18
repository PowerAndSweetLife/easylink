<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Colis;
use App\Models\Container;
use App\Models\Manifest;
use App\Models\Unit;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function index()
    {
        return view('admin.container', [
            'lists' => Manifest::join('containers', 'manifests.container_id', '=', 'containers.id')
                            ->select('manifests.*')
                            ->with('container')
                            ->with('booking')
                            ->whereIn('status', [Colis::FLOATING, Colis::TAMATAVE, Colis::TANA, Colis::READY_TO_DELIVERED])
                            ->paginate(env('PER_PAGE'))
        ]);
    }

    public function bookingList(int $id)
    {
        $manifest = Manifest::with('container')->where('id', $id)->get()->first();
        return view('admin.container-booking-list', [
            'lists' => Booking::where('manifest_id', $id)->paginate(env('PER_PAGE')),
            'manifest' => $manifest
        ]);
    }

    public function packageList(int $bookingId)
    {
        $booking = Booking::with('colis')
                        ->with('client')
                        ->where('id', $bookingId)
                        ->get()
                        ->first();
        return view('admin.modal.package-lists-content', [
            'booking' => $booking
        ]);
    }
}
