<?php

namespace App\Http\Controllers\MadaAgent;

use App\Helper\Lang;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Models\MadaAgent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return to_route('mada-agent.container');
    }

    public function changeLanguage(Request $request, string $lang)
    {
        /** @var MadaAgent */
        $user = MadaAgent::find($request->session()->get('mada-agent')['id']);
        if(in_array($lang, Lang::availables['mada-agent']))
        {
            $user->app_lang = $lang;
            $user->update();

            Session::setUserdata($request, $user);
        }
        return back();
    }
}
