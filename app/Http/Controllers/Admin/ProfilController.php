<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.profil-info', [
            "data" => Admin::find($request->session()->get('admin')['id'])
        ]);
    }

    public function password(Request $request)
    {
        return view('admin.profil-password', [
            "data" => Admin::find($request->session()->get('admin')['id'])
        ]);
    }

    public function updateInfo(Admin $admin, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "firstname" => "required",
            "lastname" => "required",
            "email" => ["required", 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('admins')->ignore($admin)],
            "contact" => "required"
        ]);
        if($validator->fails())
        {
            return redirect()->route('admin.profil.index')->withInput()->withErrors($validator);
        }
        $admin->update($validator->validated());
        return redirect()->route('admin.profil.index')->with('success', true);
    }
    public function updatePassword(Admin $admin, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "confirm-password" => "required",
            "current-password" => "required",
        ]);
        if($validator->fails())
        {
            return redirect()->route('admin.profil.password')->withInput()->withErrors($validator);
        }
        if($request->input('password') !== $request->input('confirm-password'))
        {
            return redirect()->route('admin.profil.password')->withInput()->withErrors([
                'password' => __('The two passwords are different'),
                'confirm-password' => __('The two passwords are different')
            ]);
        }

        if(!Hash::check($request->input('current-password'), $admin->password))
        {
            return redirect()->route('admin.profil.password')->withInput()->withErrors([
                'current-password' => __('Password incorrect !')
            ]);
        }
        $admin->update([
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect()->route('admin.profil.password')->with('success', true);
    }
}
