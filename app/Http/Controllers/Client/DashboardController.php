<?php

namespace App\Http\Controllers\Client;

use App\Helper\Lang;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect(route('client.expedition.create'));
    }

    public function changeLanguage(Request $request, string $lang)
    {
        /** @var Client */
        $user = Client::find($request->session()->get('client')['id']);
        if(in_array($lang, Lang::availables['client']))
        {
            $user->app_lang = $lang;
            $user->update();

            Session::setUserdata($request, $user);
        }
        return back();
    }

    public function easylink()
    {
        $agents = Agent::with('localization')->get();
        return view('client.easylink', [
            'agents' => $agents
        ]);
    }
}
