<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Colis;
use DateTime;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('package');
        if(is_null($query))
        {
            return to_route('client.expedition.index');
        }
        $clientId = $request->session()->get('client')['id'];
        return view('client.list-expedition', [
            'searchResult' => true,
            'query' => $query,
            'match' => Colis::with('category')
                            ->where('receip_number', $query)
                            ->where('client_id', $clientId)
                            ->get()
                            ->first()
        ]);
    }


    // public function run(Request $request)
    // {
    //     return to_route('client.search.index')->with('search-data', $request->input())->withInput();
    // }
}
