<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LastMessageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;

class Messagecontroller extends Controller
{
    public function index(Request $request)
    {
        return view('client.message', [
            'lists' => Message::with('admin')
                        ->where('client_id', $request->session()->get('client')['id'])
                        ->orderBy('created_at', 'desc')
                        ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required'
        ]);
        if($validator->fails())
        {
            return back();
        }
        Message::create(array_merge($validator->validated(), [
            'client_id' => $request->session()->get('client')['id'],
            'sender' => 'client'
        ]));
        $last = LastMessageClient::where('client_id', $request->session()->get('client')['id'])->get()->first();
        if($last)
        {
            $last->update([
                "message" => $validator->validated()['body']
            ]);
        }
        else 
        {
            LastMessageClient::create([
                "message" => $validator->validated()['body'],
                'client_id' => $request->session()->get('client')['id']
            ]);
        }
        return back();
    }
}
