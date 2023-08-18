<?php

namespace App\Http\Controllers\Agent;

use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReqest;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'action' => route('agent.login'),
            'label' => 'Agent login',
            'user' => 'agent',
            'withRegister' => false
        ]);
    }

    public function doLogin(AuthReqest $request)
    {
        $credentials = $request->validated();

        /** @var Agent */
        $user = Agent::where('email', $credentials['username'])
                        ->orWhere('username', $credentials['username'])
                        ->get()
                        ->first();
        if(is_null($user))
        {
            return redirect(route('agent.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }
        if(!Hash::check($credentials['password'], $user->password))
        {
            return redirect(route('agent.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }

        Session::setUserdata($request, $user);
        return to_route('agent.index');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('agent');
        return redirect(route('agent.login'));
    }

}
