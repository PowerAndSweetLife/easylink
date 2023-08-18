<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hasConfirmed(): bool
    {
        return $this->confirmed_at !== null;
    }

    public function shortName()
    {
        if($this->type === 'company')
        {
            return $this->company_name;
        }
        return __($this->civility) . " " . $this->lastname;
    }

    public function longName()
    {
        if($this->type === 'company')
        {
            return $this->company_name;
        }
        return __($this->civility). " " . $this->firstname . " " . $this->lastname;
    }

    public function name()
    {
        if($this->type === 'company')
        {
            return $this->company_name;
        }
        return $this->firstname . " " . $this->lastname;
    }
}
