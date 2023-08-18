<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subclient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function longName()
    {
        if($this->type === 'company')
        {
            return $this->company_name;
        }
        return __($this->civility). " " . $this->firstname . " " . $this->lastname;
    }
}
