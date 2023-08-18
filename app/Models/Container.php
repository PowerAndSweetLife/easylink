<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function etd()
    {
        return new DateTime($this->etd);
    }

    public function manifest()
    {
        return $this->hasOne(Manifest::class)->with('agent')->with('booking');
    }
}
