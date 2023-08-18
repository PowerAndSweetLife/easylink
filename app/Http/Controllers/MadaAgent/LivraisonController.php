<?php

namespace App\Http\Controllers\MadaAgent;

use App\Http\Controllers\Controller;
use App\Models\Colis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivraisonController extends Controller
{
    public function index(Request $request)
    {
        $query = Colis::join('clients', 'colis.client_id', '=', 'clients.id')
                    ->select('colis.*')
                    ->with('client')
                    ->where('status', Colis::READY_TO_DELIVERED);
        $uid = $request->input('uid');
        if($uid)
        {
            $query->where('uid', '=', $uid);
        }

        return view('mada-agent.livraison', [
            'lists' => $query->paginate(env('PER_PAGE')),
            'uid' => $uid
        ]);
    }

    public function single(int $id, Request $request)
    {
        /** @var Colis */
        $colis = Colis::with('client')
                    ->where('id', $id)
                    ->get()
                    ->first();
        $colis->status = Colis::DELIVERED;

        $client = $colis->client;
        $client->cbm = (float)$client->cbm + $colis->volume();
        $client->save();

        $colis->save();
        return redirect(route('mada-agent.livraison.index'))->with('success', true);
    }

    public function more(Request $request)
    {
        $idColisList = $request->input('id-list');
        DB::table('colis')
            ->whereIn('id', $idColisList)
            ->update([
                'status' => Colis::DELIVERED
            ]);

        $colis = Colis::with('client')->whereIn('id', $idColisList)->get();

        foreach($colis as $c)
        {
            $client = $c->client;
            $client->update([
                'cbm' => $client->cbm + $c->volume()
            ]);
        }


        return redirect(route('mada-agent.livraison.index'))->with('success', true);
    }

    public function show(int $id)
    {
        return view('mada-agent.modal.package-detail', [
            'colis' => Colis::find($id)
        ]);
    }
}
