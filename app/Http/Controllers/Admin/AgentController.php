<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Mail\AgentEmail;
use App\Mail\ClientMail;
use App\Models\Agent;
use App\Models\Localization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->input('pays') ?? 'chine';

        if($country === 'mada')
        {
            return redirect()->route('admin.mada-agent.index', ['pays' => 'mada']);
        }

        $data = new Agent();
        if(in_array(env('APP_ENV'), ['local', 'dev']))
        {
            $lastname = fake()->lastName();
            $data->firstname = fake()->firstName();
            $data->lastname = $lastname;
            $data->username = strtoupper(substr($lastname, 0,3));
            $data->email = fake()->email();
            $data->contact = fake()->phoneNumber();
            $data->address = json_encode([
                "small" => fake('zh_TW')->address(),
                "regular" => fake('zh_TW')->address()
            ]);
        }
        return view('admin.agent-form', [
            'localizations' => Localization::all(),
            'lists' => Agent::with('localization')->paginate(env('PER_PAGE')),
            'data' => $data,
            'active' => 'chine'
        ]);
    }

    public function store(AgentRequest $request)
    {
        $data = $request->validated();
        $data['address'] = json_encode([
            "small" => $data['address-small'],
            "regular" => $data['address-regular']
        ]);

        $plainPassword = "password";
        $password = Hash::make($plainPassword);
        $data['password'] = $password;
        $agent = Agent::create($data);
       
        Mail::send(new AgentEmail($agent, $plainPassword));

        return redirect(route('admin.agent.index'))->with('success', true);
    }

    public function edit(Agent $agent)
    {
        return view('admin.agent-form', [
            'localizations' => Localization::all(),
            'lists' => Agent::with('localization')->paginate(env('PER_PAGE')),
            'data' => $agent,
            'active' => 'chine'
        ]);
    }

    public function update(AgentRequest $request, Agent $agent)
    {
        $agent->update($request->validated());

        return redirect(route('admin.agent.index'))->with('success', true);
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return to_route('admin.agent.index');
    }
}
