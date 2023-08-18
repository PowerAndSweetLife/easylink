<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    protected $fillable = [
        "shiporder",
        "status",
        "etd",
        "eta",
        "ata",
        "freetime",
        "pic",
        "del",
        "sending_at",
        "received_at",
        "client_id",
        "agent_id",
        "booking_id",
    ];

    public function sendingAt()
    {
        return new DateTime($this->sending_at);
    }

    public function colis()
    {
        return $this->hasMany(Colis::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class)->with('localization');
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
