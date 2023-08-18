<?php

namespace App\Http\Controllers\Client;

use App\Helper\Dimension;
use App\Helper\FileManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColisRequest;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Colis;
use App\Models\Metadata;
use App\Models\Subclient;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColisController extends Controller
{
    public function store(ColisRequest $request)
    {
        $data = $request->validated();
        $data['dimensions'] = Dimension::encode($request->input('dimensions'));
        // $data['subclient'] = (int)$request->input('subclient_id');
        $data['status'] = Colis::SEND;
        $data['client_id'] = $request->session()->get('client')['id'];
        $data['send_at'] = new DateTime();
        $data['shiporder'] = $this->_generateReceiporder();

        $attachments = $request->file('attachments');
        if($attachments)
        {
            $filenames = [];
            foreach($attachments as $attach)
            {
                $filename = FileManager::generateFilename($attach, 'colis_attachments');
                $attach->storeAs('colis_attachments', $filename);
                $filenames[] = $filename;
            }
            $data['attachments'] = json_encode($filenames);
        }
        Colis::create($data);
        return redirect(route('client.expedition.create'))
                        ->with('success', true)
                        ->with('successMessage', __('Your package has been sent'));
    }

    public function edit(Request $request, int $id)
    {
        $colis = Colis::findOrFail($id);
        if($colis->status !== Colis::SEND)
        {
            return to_route('client.expedition.index');
        }
        return view('client.new-expedition',[
            'categories' => Category::all(),
            // 'subclients' => Subclient::where('client_id', $request->session()->get('client')['id'])->get(),
            // 'colisList' => Colis::with('category')
            //                 ->where('client_id', $request->session()->get('client')['id'])
            //                 ->whereNull('expedition_id')
            //                 ->get(),
            'agents' => Agent::all(),
            'data' => $colis
        ]);
    }

    public function update(ColisRequest $request, int $id)
    {
        $colis = Colis::findOrFail($id);
        $data = $request->validated();
        $data['dimensions'] = Dimension::encode($request->input('dimensions'));

        $attachments = $request->file('attachments');
        if($attachments)
        {
            $filenames = [];
            foreach($attachments as $attach)
            {
                $filename = FileManager::generateFilename($attach, 'colis_attachments');
                $attach->storeAs('colis_attachments', $filename);
                $filenames[] = $filename;
            }
            if($colis->attachments)
            {
                $oldFiles = json_decode($colis->attachments);
                foreach($oldFiles as $old)
                {
                    Storage::delete('colis_attachments/' . $old);
                }
            }
            $data['attachments'] = json_encode($filenames);
        }
        
        $colis->update($data);

        return redirect(route('client.expedition.create'))
                        ->with('success', true)
                        ->with('successMessage', __('Your package has been successfully modified'));
    }

    public function destroy(int $id)
    {
        $colis = Colis::findOrFail($id);
        if($colis->status !== Colis::SEND)
        {
            return to_route('client.expedition.index');
        }
        if($colis->attachments)
        {
            $oldFiles = json_decode($colis->attachments);
            foreach($oldFiles as $old)
            {
                Storage::delete('colis_attachments/' . $old);
            }
        }
        $colis->delete();
        return redirect(route('client.expedition.create'));
    }

    private function _generateReceiporder(): string
    {
        $current = Metadata::where('key', date('Y') . '_last_shiporder')->get()->first();
        $new = null;
        if(is_null($current))
        {
            $new = 1;
            $metadata = new Metadata([
                'key' => date('Y') . '_last_shiporder',
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

        return "T" . date('y') . str_pad($new, 4, "0", STR_PAD_LEFT);
    }

}
