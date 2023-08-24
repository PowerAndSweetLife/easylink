<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReqest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        App::setLocale('fr');
    }
    public function login()
    {
        return view('auth.login', [
            'action' => route('admin.login'),
            'label' => 'Connexion administrateur',
            'user' => 'admin',
            'withRegister' => false
        ]);
    }
    // public function forgotPassword()
    // {
    //     return view('auth.forgot-password', [
    //         'user' => 'admin'
    //     ]);
    // }
    public function doLogin(AuthReqest $request)
    {
        $credentials = $request->validated();

        /** @var Admin */
        $user = Admin::where('email', $credentials['username'])
                        ->orWhere('username', $credentials['username'])
                        ->get()
                        ->first();
        if(is_null($user))
        {
            return redirect(route('admin.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }
        if(!Hash::check($credentials['password'], $user->password))
        {
            return redirect(route('admin.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }

        Session::setUserdata($request, $user);
        return to_route('admin.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect(route('admin.login'));
    }

}
