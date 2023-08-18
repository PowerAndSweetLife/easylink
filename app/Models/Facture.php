<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class)->with('colis')->with('client')->with('agent')->with('manifest');
    }

    public function reference(): string
    {
        return sprintf("1%s", str_pad($this->id, 5, "0", STR_PAD_LEFT));
    }
}
