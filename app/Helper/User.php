<?php

namespace App\Helper;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Client;
use App\Models\MadaAgent;

class User {

    protected  $userObject;

    public static $instance;


    public function findInSession(string $type)
    {
        if($this->userObject !== null)
        {
            return $this->userObject;
        }

        $user = session($type);
        if(!$user)
        {
            return null;
        }

        $id = $user['id'];
        if($type === 'client')
        {
            $this->userObject = Client::find($id);
        }
        else if($type === 'agent')
        {
            $this->userObject = Agent::find($id);
        }
        else if($type === 'admin')
        {
            $this->userObject = Admin::find($id);
        }
        else if($type === 'mada-agent')
        {
            $this->userObject = MadaAgent::find($id);
        }

        return $this->userObject;
    }

    public static function getInstance(): self
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function languages($usertype): array
    {
        $languages = [
            "fra" => new Lang("fr", __('French'), "flag-icon-fra"),
            "gbr" => new Lang("en", __('English'), "flag-icon-gbr"),
            "chn" => new Lang("chn", __('Chinese simplified'), "flag-icon-chn")
        ];

        if($usertype === 'client' || $usertype === 'admin' || $usertype === 'mada-agent')
        {
            unset($languages['chn']);
        }
        else if($usertype === 'agent')
        {
            unset($languages['fra']);
        }

        return $languages;
    }
}