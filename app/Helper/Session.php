<?php

namespace App\Helper;

use App\Models\Admin;
use App\Models\Client;
use Illuminate\Http\Request;

class Session {
    
    /**
     * Mettre en session des donnée utilisateur
     *
     * @param  Request $request
     * @param  Client|Admin $data
     * @param  mixed $withConfirmation
     * @return void
     */
    public static function setUserdata(Request $request, $data): void
    {
        $info = [
            "id" => $data->id,
            "lang" => $data->app_lang
        ];
        if($data instanceof Client)
        {
            $info["confirmed"] = $data->hasConfirmed();
        }
        $classnameParts = explode("\\", get_class($data));
        $key = strtolower(end($classnameParts));
        
        if($key === 'madaagent')
        {
            $key = 'mada-agent';
        }
        $request->session()->put($key, $info);
    }

}