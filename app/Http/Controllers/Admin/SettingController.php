<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index', [
            'lists' => Category::with('admin')->paginate(env('PER_PAGE'))
        ]);
    }

    public function cbm()
    {
        return view('admin.setting.cbm',[
            'data' => Metadata::with('admin')->where('key', 'cbm_min')->get()->first()
        ]);
    }

    public function updateCbm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cbm_min' => 'required'
        ]);
        if($validator->fails())
        {
            return redirect()->route('admin.setting.cbm')->withInput()->withErrors($validator);
        }

        $metadata = Metadata::where('key', 'cbm_min')->get()->first();
        $metadata->key = 'cbm_min';
        $metadata->value = $request->input('cbm_min');
        $metadata->admin_id = $request->session()->get('admin')['id'];
        $metadata->save();

        return redirect()->route('admin.setting.cbm')->with('success', true);
    }
}
