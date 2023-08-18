<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEntrepriseRequest;
use App\Http\Requests\ClientParticulierRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        return view('client.profil-info', [
            "data" => Client::find($request->session()->get('client')['id'])
        ]);
    }

    public function password(Request $request)
    {
        return view('client.profil-password', [
            "data" => Client::find($request->session()->get('client')['id'])
        ]);
    }

    public function updateInfoCompany(Client $client, ClientEntrepriseRequest $request)
    {
        $data = $request->validated();
        unset($data['password']);
        unset($data['confirm-password']);
        $client->update($data);
        return redirect()->route('client.profil.index')->with('success', true);
    }
    public function updateInfoIndividual(Client $client, ClientParticulierRequest $request)
    {
        $data = $request->validated();
        unset($data['password']);
        unset($data['confirm-password']);
        $client->update($data);
        return redirect()->route('client.profil.index')->with('success', true);
    }
    public function updatePassword(Client $client, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "confirm-password" => "required",
            "current-password" => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->route('client.profil.password')->withInput()->withErrors($validator);
        }
        if($request->input('password') !== $request->input('confirm-password'))
        {
            return redirect()->route('client.profil.password')->withInput()->withErrors([
                'password' => __('The two passwords are different'),
                'confirm-password' => __('The two passwords are different')
            ]);
        }

        if(!Hash::check($request->input('current-password'), $client->password))
        {
            return redirect()->route('client.profil.password')->withInput()->withErrors([
                'current-password' => __('Password incorrect !')
            ]);
        }
        $client->update([
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect()->route('client.profil.password')->with('success', true);
    }

    public function fidelityCard(Request $request)
    {
        $client = Client::find($request->session()->get('client')['id']);
        if($client->cbm > 200)
        {
            return view('client.components.card.vip', [
                'client' => $client
            ]);
        }
        return view('client.components.card.regular', [
            'client' => $client
        ]);
    }
}
