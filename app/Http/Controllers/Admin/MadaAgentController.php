<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MadaAgentRequest;
use App\Mail\MadaAgentEmail;
use App\Models\MadaAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MadaAgentController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->input('pays') ?? 'mada';

        if($country === 'chine')
        {
            return redirect()->route('admin.agent.index');
        }

        return view('admin.agent-form', [
            'lists' => MadaAgent::paginate(env('PER_PAGE')),
            'active' => 'mada'
        ]);
    }

    public function store(MadaAgentRequest $request)
    {
        $data = $request->validated();

        $plainPassword = "password";
        $data['password'] = Hash::make($plainPassword);
        $agent = MadaAgent::create($data);

        
        Mail::send(new MadaAgentEmail($agent, $plainPassword));

        return redirect(route('admin.mada-agent.index'))->with('success', true);
    }

    public function edit(int $id)
    {
        $agent = MadaAgent::findOrFail($id);
        return view('admin.agent-form', [
            'lists' => MadaAgent::paginate(env('PER_PAGE')),
            'data' => $agent,
            'active' => 'mada'
        ]);
    }

    public function update(MadaAgentRequest $request, int $id)
    {
        $agent = MadaAgent::findOrFail($id);
        $agent->update($request->validated());

        return redirect(route('admin.mada-agent.index'))->with('success', true);
    }

    public function destroy(int $id)
    {
        $agent = MadaAgent::findOrFail($id);
        $agent->delete();
        return to_route('admin.mada-agent.index');
    }
}
