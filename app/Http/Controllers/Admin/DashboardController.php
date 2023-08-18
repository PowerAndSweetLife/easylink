<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Lang;
use App\Helper\Session;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect(route('admin.setting.index'));
    }

    public function changeLanguage(Request $request, string $lang)
    {
        /** @var Admin */
        $user = Admin::find($request->session()->get('admin')['id']);
        if(in_array($lang, Lang::availables['admin']))
        {
            $user->app_lang = $lang;
            $user->update();

            Session::setUserdata($request, $user);
        }
        return back();
    }
}
