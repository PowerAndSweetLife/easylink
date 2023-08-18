<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LastMessageClient;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{

    public function index()
    {
        //config()->set('database.connections.mysql.strict', false);

        return view('admin.message-list', [
            'lists' => LastMessageClient::with(['client'])
                            ->get()
        ]);
    }

    public function show(Message $message)
    {
        return view('admin.message', [
            'lists' => Message::with(['admin', 'client'])
                            ->where('client_id', $message->client_id)
                            ->orderBy('created_at', 'desc')
                            ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
            'client_id' => 'required'
        ]);
        if($validator->fails())
        {
            return back();
        }
        Message::create(array_merge($validator->validated(), [
            'admin_id' => $request->session()->get('admin')['id'],
            'sender' => 'admin'
        ]));
        return back();
    }
}
