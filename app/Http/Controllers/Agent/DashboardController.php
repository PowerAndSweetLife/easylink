<?php

namespace App\Http\Controllers\Agent;

use App\Helper\Lang;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
        return redirect(route('agent.colis.list', ['status' => 'not-received']));
    }

    public function changeLanguage(Request $request, string $lang)
    {
        /** @var Agent */
        $user = Agent::find($request->session()->get('agent')['id']);
        if(in_array($lang, Lang::availables['agent']))
        {
            $user->app_lang = $lang;
            $user->update();

            Session::setUserdata($request, $user);
        }
        return back();
    }

}
