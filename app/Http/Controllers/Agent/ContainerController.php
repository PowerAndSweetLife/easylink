<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerRequest;
use App\Models\Colis;
use App\Models\Container;
use App\Models\Manifest;
use App\Models\Metadata;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function index()
    {
        return view('agent.container-list', [
            'lists' => Container::all()
        ]);
    }
    public function create()
    {
        $data = new Container();
        if(in_array(env('APP_ENV'), ['local', 'dev']))
        {
            $data->number = fake()->regexify('[A-Z]{5}[0-9]{3}');
            $data->type = "40'";
            $data->carrier = fake()->company();
            $data->vessel_voyage = ucfirst(fake()->word()) . "/" . ucfirst(fake()->word());
            $data->etd = date('Y-m-d');
            $data->port_of_load = "China";
            $data->port_of_discharge = "Tamatave";
        }
        return view('agent.container-form', [
            'data' => $data
        ]);
    }

    public function store(ContainerRequest $request)
    {
        $data = $request->validated();
        $data['agent_id'] = $request->session()->get('agent')['id'];
        $container = new Container($data);
        $container->save();

        Manifest::create([
            "container_id" => $container->id,
            "agent_id" => $request->session()->get('agent')['id'],
            "reference" => $this->_generateManifestReference(),
            "status" => Colis::ONBOARD
        ]);

        return redirect(route('agent.container.create'))->with('success', true);
    }

    public function edit(Container $container)
    {
        return view('agent.container-form', [
            'data' => $container
        ]);
    }

    public function update(ContainerRequest $request, Container $container)
    {
        $container->update($request->validated());
        return redirect(route('agent.container.create'))->with('success', true);
    }

    public function destroy(Container $container)
    {
        try {
            $container->delete();
        } catch (\Throwable $th) {
            if($th instanceof QueryException) {
                return to_route('agent.container.index')->withErrors([
                    'delete-failed' => __("Container already in use")
                ]);
            }
        }
        
        return redirect(route('agent.container.index'));
    }

    private function _generateManifestReference(): string
    {
        $current = Metadata::where('key', date('Y') . '_last_manifest_ref')->get()->first();
        $new = null;
        if(is_null($current))
        {
            $new = 1;
            $metadata = new Metadata([
                'key' => date('Y') . '_last_manifest_ref',
                'value' => 1
            ]);
            $metadata->save();
        }
        else
        {
            $new = (int)$current->value + 1;
            $current->value = $new;
            $current->save();
        }

        return "M" . date('y') . str_pad($new, 4, "0", STR_PAD_LEFT);
    }
}
