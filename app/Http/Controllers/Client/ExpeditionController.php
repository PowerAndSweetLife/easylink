<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Colis;
use App\Models\Expedition;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class ExpeditionController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status') ?? 'en-cours';
        $lists = new LengthAwarePaginator([], 0, 5);
        if(!in_array($status, ['en-cours', 'recu', 'a-expedier', 'livre']))
        {
            return redirect()->route('client.expedition.index', ['status' => 'en-cours'], 301);
        }

        $count = [
            "en-cours" => Colis::where('client_id', $request->session()->get('client')['id'])->where('status', Colis::SEND)->count(),
            "recu" => Colis::where('client_id', $request->session()->get('client')['id'])->where('status', Colis::RECEIVED)->count(),
            "a-expedier" => Colis::where('client_id', $request->session()->get('client')['id'])->whereNotIn('status', [Colis::SEND, Colis::RECEIVED, Colis::DELIVERED])->count(),
            "livre" => Colis::where('client_id', $request->session()->get('client')['id'])->where('status', Colis::DELIVERED)->count()
        ];
        switch ($status) {
            case 'en-cours':
                if($count['en-cours'] > 0)
                {
                    $lists = Colis::where('client_id', $request->session()->get('client')['id'])
                            ->where('status', Colis::SEND)
                            ->orderBy('send_at', 'desc')
                            ->paginate(5);
                }
                break;
            case 'recu':
                if($count['recu'])
                {
                    $lists = Colis::where('client_id', $request->session()->get('client')['id'])
                            ->where('status', Colis::RECEIVED)
                            ->orderBy('receive_at', 'desc')
                            ->paginate(5);
                }
                break;
            case 'a-expedier':
                if($count['a-expedier'] > 0) 
                {
                    $lists = Booking::with(['manifest', 'colisToShip', 'client'])
                                ->where('client_id', $request->session()->get('client')['id'])
                                ->whereNotNull('manifest_id')
                                ->paginate(5);
                }
                break;
            case 'livre':
                if($count['livre'])
                {
                    $lists = Colis::with('category')
                            ->where('client_id', $request->session()->get('client')['id'])
                            ->where('status', Colis::DELIVERED)
                            ->orderBy('receive_at', 'desc')
                            ->paginate(15);
                }
                break;
            default:
                # code...
                break;
        }
        
        $lists->appends('status', $status);
        return view('client.list-expedition', [
            'status' => $status,
            'lists' => $lists,
            'count' => $count
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        $data = [
            'categories' => $categories,
            'agents' => Agent::all()
        ];

        if(in_array(env('APP_ENV'), ['local', 'dev']))
        {

            $colis = new Colis([
                "receip_number" => fake()->regexify('[A-Z]{5}[0-9]{3}'),
                "courrier_company" => fake()->company(),
                "category_id" => ($categories[rand(0, $categories->count() - 1)])->id,
                "description" => join(",", fake()->words(rand(1,5))),
                "dimensions" => json_encode([[
                    "count" => rand(1,5),
                    "length" => rand(50, 100),
                    "width" => rand(50, 100),
                    "height" => rand(50, 100),
                    "weight" => rand(5, 100),
                ]])
            ]);
            
            $data['data'] = $colis;
        }

        return view('client.new-expedition', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required'
        ]);
        if($validator->fails())
        {
            return redirect(route('client.expedition.index'))->withInput(['agent_id'])->withErrors($validator);
        }
        $expedition = Expedition::create([
            "status" => Colis::SEND,
            "client_id" => $request->session()->get('client')['id'],
            "agent_id" => $request->input('agent_id'),
            "sending_at" => new DateTime()
        ]);

        foreach($request->input('colis-id') as $id)
        {
            $colis = Colis::find($id);
            $colis->update([
                'expedition_id' => $expedition->id,
                "agent_id" => $request->input('agent_id')
            ]);
        }
        return redirect(route('client.expedition.create'))->with('success', true);
    }

    
    // private function _formatForOptions($subclients)
    // {
    //     $data = [];
    //     foreach ($subclients as $k => $subclient) 
    //     {
    //         if($subclient->type === 'company')
    //         {
    //             $data[$subclient->id] = $subclient->company_name;
    //         }
    //         else 
    //         {
    //             $data[$subclient->id] = $subclient->firstname ."  " . $subclient->lastname;
    //         }
    //     }

    //     return $data;
    // }
}
