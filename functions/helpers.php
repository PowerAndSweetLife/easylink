<?php

use App\Helper\Lang;
use App\Helper\MenusList;
use App\Helper\User;
use Illuminate\Support\Facades\Route;

if(!function_exists('user')) {

    function user(string $key)
    {
        $currentRoute = Route::getCurrentRoute()->getName();
        $partsRoute = explode(".", $currentRoute);
        /** @var User */
        $userHelper = User::getInstance();
        $user = $userHelper->findInSession($partsRoute[0]);
        
        if($key === 'usertype')
        {
            return $partsRoute[0];
        }
        if($user)
        {
            return $user->$key;
        }
        return null;
    }
}

if(!function_exists('flagIcon')) {
    function flagIcon(string $lang): string
    {
        return Lang::getFlagIcon($lang);
    }
}

if(!function_exists('languages')){
    function languages(string $usertype): array
    {
        return User::languages($usertype);
    }
}

if(!function_exists('menusList')) {
    function menusList(string $usertype): array
    {
        if($usertype === 'client')
        {
            return MenusList::client();
        }
        if($usertype === 'admin')
        {
            return MenusList::admin();
        }
        if($usertype === 'agent')
        {
            return MenusList::agent();
        }
        if($usertype === 'mada-agent')
        {
            return MenusList::madaAgent();
        }
    }
}

if(!function_exists('currentRoute')) {

    function currentRouteName() {
        return Route::getCurrentRoute()->getName();
    }
}

if(!function_exists('price')) {

    function price($price = null) {
        if(!$price) {
            return round(0, 2);
        }
        return number_format((float)$price, 2, '.', ' ');
    }
}

if(!function_exists('shortDate')) {

    function shortDate(?string $date = null) {
        if(is_null($date)) {
            return null;
        }
        return (new DateTime($date))->format("d/m/Y");
    }
}


    