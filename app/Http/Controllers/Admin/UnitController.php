<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return view('admin.setting.unit', [
            'lists' => Unit::with('admin')->paginate(env('PER_PAGE'))
        ]);
    }

    public function store(UnitRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        Unit::create($data);
        return redirect(route('admin.unit.index'))->with('success', true);
    }

    public function edit(Unit $unit)
    {
        return view('admin.setting.unit', [
            'lists' => Unit::with('admin')->paginate(env('PER_PAGE')),
            'data' => $unit
        ]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->session()->get('admin')['id'];
        $unit->update($data);
        return redirect(route('admin.unit.index'))->with('success', true);
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
        } catch (\Throwable $th) {
            if($th instanceof QueryException) {
                return to_route('admin.unit.index')->withErrors([
                    'delete-failed' => __("Unit already in use")
                ]);
            }
        }
        return to_route('admin.unit.index');
    }
}
