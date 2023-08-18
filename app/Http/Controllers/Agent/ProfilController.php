<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        return view('agent.profil-info', [
            "data" => Agent::find($request->session()->get('agent')['id'])
        ]);
    }

    public function password(Request $request)
    {
        return view('agent.profil-password', [
            "data" => Agent::find($request->session()->get('agent')['id'])
        ]);
    }

    public function updateInfo(Agent $agent, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => "required",
            "lastname" => "required",
            "email" => ["required", 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('admins')->ignore($agent)],
            "contact" => "required"
        ]);
        if($validator->fails())
        {
            return redirect()->route('agent.profil.index')->withInput()->withErrors($validator);
        }
        $agent->update($validator->validated());
        return redirect()->route('agent.profil.index')->with('success', true);
    }
    public function updatePassword(Agent $agent, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "confirm-password" => "required",
            "current-password" => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->route('agent.profil.password')->withInput()->withErrors($validator);
        }
        if($request->input('password') !== $request->input('confirm-password'))
        {
            return redirect()->route('agent.profil.password')->withInput()->withErrors([
                'password' => __('The two passwords are different'),
                'confirm-password' => __('The two passwords are different')
            ]);
        }

        if(!Hash::check($request->input('current-password'), $agent->password))
        {
            return redirect()->route('agent.profil.password')->withInput()->withErrors([
                'current-password' => __('Password incorrect !')
            ]);
        }
        $agent->update([
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect()->route('agent.profil.password')->with('success', true);
    }
}
