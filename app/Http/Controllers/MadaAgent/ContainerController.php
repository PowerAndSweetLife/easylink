<?php

namespace App\Http\Controllers\MadaAgent;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Colis;
use App\Models\Manifest;
use App\Models\Unit;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{
    public function index()
    {
        return view('mada-agent.container', [
            'lists' => Manifest::join('containers', 'manifests.container_id', '=', 'containers.id')
                            ->select('manifests.*')
                            ->with('container')
                            ->with('booking')
                            ->whereIn('status', [Colis::FLOATING, Colis::TAMATAVE, Colis::TANA, Colis::READY_TO_DELIVERED])
                            ->paginate(env('PER_PAGE'))
        ]);
    }

    public function editDate(Request $request, int $id)
    {
        $manifest = Manifest::with('container')
                        ->where('id', $id)
                        ->get()
                        ->first();
        $allDateIsNotNull = true;
        foreach($manifest->toArray() as $key => $value)
        {
            if(in_array($key, ['eta', 'ata', 'freetime', 'del']) && $value === null)
            {
                $allDateIsNotNull = false;
                break;
            }
        }
        return view('mada-agent.container-edit-date', [
            'data' => $manifest,
            'allNotNull' => $allDateIsNotNull
        ]);
    }
    public function editStatus(Request $request, int $id)
    {
        return view('mada-agent.container-edit-status', [
            'data' => Manifest::where('container_id', $id)->get()->first(),
            'status' => [
                Colis::FLOATING => __('Floating'),
                Colis::TAMATAVE => __('Tamatave'),
                Colis::TANA => "Tanà",
                Colis::READY_TO_DELIVERED => "Ready to delivered",
            ]
        ]);
    }
    public function editPrice(Request $request, int $id)
    {
        return view('mada-agent.container-edit-price', [
            'data' => Manifest::where('container_id', $id)->get()->first(),
            'units' => Unit::all()
        ]);
    }

    public function show(Request $request, int $id)
    {
        return view('mada-agent.container-edit-date', [
            'data' => Manifest::where('container_id', $id)->get()->first()
        ]);
    }

    public function updateDate(Request $request, int $id)
    {
        $manifest = Manifest::find($id);
        $manifest->eta = $request->input('eta');
        $manifest->ata = $request->input('ata');
        $manifest->del = $request->input('del');
        $manifest->freetime = $request->input('freetime') ?? 0;

        $pic = null;
        $foc = null;

        if($manifest->freetime === null) {
            $manifest->freetime = 0 ;
        }

        if($request->input('ata'))
        {
            // $dt = new DateTime($request->input('ata'));
            // $pic = $dt->add(DateInterval::createFromDateString('7 day'));
            // $foc = $pic->add(DateInterval::createFromDateString('5 day'));
            // $manifest->pic = $pic;
            // $manifest->foc = $foc;

            $newFoc = $manifest->freetime + 7 ;
            $dt = new DateTime($request->input('ata'));
            $dt1 = new DateTime($request->input('ata'));

            $manifest->pic = $dt->add(DateInterval::createFromDateString('7 day'));
            $manifest->foc = $dt1->add(DateInterval::createFromDateString(''.$newFoc.' day'));
        }
        // if($request->input('del') && $request->input('freetime'))
        // {
        //     $dt = new DateTime($request->input('del'));
        //     $pic = $dt->add(DateInterval::createFromDateString((int)$request->input('freetime') . ' day'));
        //     $manifest->pic = $pic;
        // }
        $manifest->save();

        return redirect(route('mada-agent.container.editDate', ['id' => $manifest->container_id]))->with('success', true);
    }

    public function updateStatus(Request $request, int $id)
    {
        $manifest = Manifest::find($id);
        $manifest->status = $request->input('status');
        $manifest->save();

        /**
         * Update status colis
         */
        $bookings = Booking::where('manifest_id', $id)->get();
        foreach($bookings as $booking)
        {
            DB::table('colis')
                ->where('booking_id', $booking->id)
                ->update(['status' => $request->input('status')]);
        }

        return redirect(route('mada-agent.container.editStatus', ['id' => $manifest->container_id]))->with('success', true);  
    }

    public function updatePrice(Request $request, int $id)
    {
        $manifest = Manifest::find($id);
        $manifest->bmoi_rate = $request->input('bmoi_rate');
        $manifest->unit = $request->input('unit');
        $manifest->save();
        return redirect(route('mada-agent.container.editPrice', ['id' => $manifest->container_id]))->with('success', true);  
    }

    public function bookingList(int $id)
    {
        $manifest = Manifest::with('container')->where('id', $id)->get()->first();
        return view('mada-agent.container-booking-list', [
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
        return view('mada-agent.modal.package-lists-content', [
            'booking' => $booking
        ]);
    }
}
