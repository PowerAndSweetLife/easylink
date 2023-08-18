<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Subclient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubclientController extends Controller
{
    public function index(Request $request)
    {
        return view('client.subclient-list', [
            'lists' => Subclient::where('client_id', $request->session()->get('client')['id'])->get()
        ]);
    }

    public function create(Request $request)
    {
        $type = $request->input('type') ?? 'entreprise';
        return view('client.subclient-form', [
            'active' => $type
        ]);
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $validator = null;
        if($type === 'company')
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', 'unique:subclients'],
                'contact' => ['required'],
                'nif' => ['required'],
                'stat' => ['required'],
                'rcs' => ['required'],
                'type' => ['required'],
                'company_name' => ['required'],
            ]);
        }
        else 
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', 'unique:subclients'],
                'contact' => ['required'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'civility' => ['required'],
                'type' => ['required'],
            ]);    
        }

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        Subclient::create(array_merge($validator->validated(), ['client_id' => $request->session()->get('client')['id']]));
        return back()->with('success', true);
        
    }

    public function edit(Subclient $subclient)
    {
        $type = $subclient->type === 'company' ? 'entreprise' : 'particulier';
        return view('client.subclient-form', [
            'active' => $type,
            'data' => $subclient
        ]);
    }

    public function update(Request $request, Subclient $subclient)
    {
        $type = $request->input('type');
        $validator = null;
        if($type === 'company')
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('subclients')->ignore($subclient)],
                'contact' => ['required'],
                'nif' => ['required'],
                'stat' => ['required'],
                'rcs' => ['required'],
                'type' => ['required'],
                'company_name' => ['required'],
            ]);
        }
        else 
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'regex:/[\w\d\-]+@[\w\-]+\.[a-z]+/i', Rule::unique('subclients')->ignore($subclient)],
                'contact' => ['required'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'civility' => ['required'],
                'type' => ['required'],
            ]);    
        }

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $subclient->update($validator->validated());
        return  to_route('client.subclient.index')->with('success', true);
        
    }

    public function destroy(Subclient $subclient)
    {
        $subclient->delete();
        return  to_route('client.subclient.index');
    }
}
