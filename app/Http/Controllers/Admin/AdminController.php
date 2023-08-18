<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminReqest;
use App\Mail\AdminEmail;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $lists = Admin::where("id","<>", $request->session()->get('admin')['id'])->get();
        
        return view('admin.admin-form', [
            'lists' => $lists
        ]);
    }

    public function store(AdminReqest $request)
    {
        $data = $request->validated();
        
        $plainPassword = 'password';
        $data["password"] = Hash::make($plainPassword);
        $admin = Admin::create($data);
        
        Mail::send(new AdminEmail($admin, $plainPassword));

        return redirect(route('admin.admin.index'))->with('success', true);
    }

    public function edit(Admin $admin, Request $request)
    {
        $lists = Admin::where("id","<>", $request->session()->get('admin')['id'])->get();
        return view('admin.admin-form', [
            'lists' => $lists,
            'data' => $admin
        ]);
    }

    public function update(AdminReqest $request, Admin $admin)
    {
        $admin->update($request->validated());
        return to_route('admin.admin.index')->with('success', true);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return to_route('admin.admin.index');
    }
}
