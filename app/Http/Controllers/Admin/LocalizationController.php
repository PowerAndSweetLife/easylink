<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocalizationRequest;
use App\Models\Localization;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class LocalizationController extends Controller
{
    public function index()
    {
        return view('admin.setting.localization',[
            'lists' => Localization::with('admin')->paginate(env('PER_PAGE'))
        ]);
    }

    public function store(LocalizationRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        Localization::create($data);
        return redirect(route('admin.localization.index'))->with('success', true);
    }

    public function edit(Localization $localization)
    {
        return view('admin.setting.localization',[
            'lists' => Localization::with('admin')->paginate(env('PER_PAGE')),
            'data' => $localization
        ]);
    }

    public function update(Localization $localization, LocalizationRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        $localization->update($data);
        return redirect(route('admin.localization.index'))->with('success', true);
    }

    public function destroy(Localization $localization)
    {
        try {
            $localization->delete();
        } catch (\Throwable $th) {
            if($th instanceof QueryException) {
                return to_route('admin.localization.index')->withErrors([
                    'delete-failed' => __("Localization already in use")
                ]);
            }
        }
        return to_route('admin.localization.index');
    }
}
