<?php

namespace App\Helper;


class Menu {
    
    public string $label;

    public string $icon;

    public string $link;

    public bool $active = false;


    public function __construct(string $label, string $icon, string $link, bool $active)
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->link = $link;
        $this->active = $active;
    }
}