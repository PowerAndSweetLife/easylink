<?php

namespace App\Helper;


class Lang {

    const availables = [
        "admin" => ["fr","en"],
        "client" => ["fr","en"],
        "agent" => ["chn","en"],
        "mada-agent" => ["fr","en"],
    ];

    public string $code;
    
    public string $name;

    public string $flag;

    public function __construct(string $code, string $name, string $flag)
    {
        $this->code = $code;
        $this->name = $name;
        $this->flag = $flag;
    }

    public static function getFlagIcon(string $lang): ?string
    {
        switch ($lang) {
            case 'fr':
                return "flag-icon-fra";
            case 'en':
                return "flag-icon-gbr";
            case 'chn':
                return "flag-icon-chn";
            default:
                return null;
        }
    }

}