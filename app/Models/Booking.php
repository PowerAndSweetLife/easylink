<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "reference",
        "cob",
        "is_open",
        "client_id",
        "agent_id"
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function volume()
    {
        $volume = 0;
        foreach($this->colis as $colis)
        {
            $volume += $colis->volume();
        }
        return $volume;
    }

    public function colis()
    {
        return $this->hasMany(Colis::class);
    }
    
    public function colisToShip()
    {
        return $this->hasMany(Colis::class)->with('category')
                    ->whereNotIn('status', [Colis::SEND, Colis::RECEIVED, Colis::DELIVERED]);
    }

    public function manifest()
    {
        return $this->belongsTo(Manifest::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
