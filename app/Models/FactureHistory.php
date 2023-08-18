<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function datePaiement()
    {
        return new DateTime($this->date_paiement);
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class)->with('booking');
    }
}
