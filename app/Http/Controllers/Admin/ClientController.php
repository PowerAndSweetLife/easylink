<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $querySearch = $request->input('query');
        $query = Client::whereNotNull('confirmed_at');
        if($querySearch)
        {
            $query->where(function ($q) use($querySearch){
                $q->where('uid', 'like', "%$querySearch%")
                    ->orWhere('firstname', 'like', "%$querySearch%")
                    ->orWhere('lastname', 'like', "%$querySearch%")
                    ->orWhere('company_name', 'like', "%$querySearch%");
            });
            
        }
        return view('admin.client', [
            "lists" => $query->paginate(50),
            "query" => $querySearch
        ]);
    }
}
