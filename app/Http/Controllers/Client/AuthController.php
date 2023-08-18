<?php

namespace App\Http\Controllers\Client;

use App\Helper\Code;
use App\Helper\JWT;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthReqest;
use App\Mail\ClientMail;
use App\Mail\PasswordMail;
use App\Models\Client;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function __construct()
    {
        App::setLocale('fr');
    }
    public function login(Request $reqest)
    {
        return view('auth.login', [
            'action' => route('client.login'),
            'label' => 'Connexion client',
            'user' => 'client',
            'withRegister' => true
        ]);
    }

    public function doLogin(AuthReqest $request)
    {
        $credentials = $request->validated();

        /** @var Client */
        $user = Client::where('email', $credentials['username'])
                        ->orWhere('uid', $credentials['username'])
                        ->get()
                        ->first();
        if(is_null($user))
        {
            return redirect(route('client.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }
        if(!Hash::check($credentials['password'], $user->password))
        {
            return redirect(route('client.login'))->withInput()->withErrors([
                'loginError' => true
            ]);
        }

        Session::setUserdata($request, $user);
        return to_route('client.index');
    }

    public function confirmEmail(Request $request)
    {
        $client = Client::find($request->session()->get('client')['id']);
        return view('auth.confirm-email', [
            'client' => $client
        ]);
    }

    public function doConfirmEmail(Request $request)
    {
        $id = (int)$request->session()->get('client')['id'];
        $code = trim($request->input("code"));

        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);
        if($validator->fails())
        {
            return redirect(route('client.confirm-email'))->withInput()->withErrors($validator);
        }

        $client = Client::find($id);
        if($code !== $client->email_confirmation_code)
        {
            return redirect(route('client.confirm-email'))->withInput()->withErrors([
                'code' => __('Code incorrect!')
            ]);
        }

        $client->confirmed_at = new DateTime();
        $client->save();

        Session::setUserdata($request, $client);
        return to_route('client.index');
    }

    public function editEmail(Request $request)
    {
        $client = Client::find($request->session()->get('client')['id']);
        return view('auth.modify-email', [
            'client' => $client,
        ]);
    }

    public function updateEmail(Request $request)
    {
        /** @var Client */
        $client = Client::find($request->session()->get('client')['id']);
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('clients')->ignore($client)]
        ]);

        if($validator->fails())
        {
            return redirect(route('client.change-email'))->withInput()->withErrors($validator);
        }

        $client->email = $validator->validated()['email'];
        $client->email_confirmation_code = Code::generateConfirmation();
        $client->update();
        Mail::send(new ClientMail($client));
        
        return redirect(route('client.confirm-email'));
    }

    public function regenerateCode(Request $request)
    {
        $client = Client::find($request->session()->get('client')['id']);
        $client->email_confirmation_code = Code::generateConfirmation();

        $client->update();

        Mail::send(new ClientMail($client));

        return redirect(route('client.confirm-email'));
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password', [
            'user' => 'client'
        ]);
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i']
        ]);

        if($validator->fails())
        {
            return redirect(route('client.forgot-password'))->withInput()->withErrors($validator);
        }

        $client = Client::where('email', $validator->validated()['email'])->get()->first();
        if($client)
        {
            $password = Code::generatePassword();
            $client->password = Hash::make($password);
            $client->update();
            Mail::send(new PasswordMail($client, $password));
        }

        

        return redirect(route('client.login'))->with('password-modified', true);
    }

    
    public function logout(Request $request)
    {
        $request->session()->forget('client');
        return redirect(route('client.login'));
    }
}
