<?php

namespace App\Http\Controllers\MadaAgent;

use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReqest;
use App\Models\MadaAgent;
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
            'action' => route('mada-agent.login'),
            'label' => 'Connexion agent',
            'user' => 'agent',
            'withRegister' => false
        ]);
    }

    public function doLogin(AuthReqest $request)
    {
        $credentials = $request->validated();

        /** @var MadaAgent */
        $user = MadaAgent::where('email', $credentials['username'])
                        ->orWhere('username', $credentials['username'])
                        ->get()
                        ->first();
        if(is_null($user))
        {
            return redirect(route('mada-agent.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }
        if(!Hash::check($credentials['password'], $user->password))
        {
            return redirect(route('mada-agent.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }

        Session::setUserdata($request, $user);
        return to_route('mada-agent.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('agent');
        return redirect(route('agent.login'));
    }
}
