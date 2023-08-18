<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function eta()
    {
        if($this->eta !== null)
        {
            return new DateTime($this->eta);
        }
        return null;
    }
    public function ata()
    {
        if($this->ata !== null)
        {
            return new DateTime($this->ata);
        }
        return null;
    }
    public function del()
    {
        if($this->del !== null)
        {
            return new DateTime($this->del);
        }
        return null;
    }
    public function pic()
    {
        if($this->pic !== null)
        {
            return new DateTime($this->pic);
        }
        return null;
    }

    public function volume()
    {
        $volume = 0;
        foreach($this->booking as $booking)
        {
            foreach($booking->colis as $colis)
            {
                $volume += $colis->volume();
            }
        }
        return $volume;
    }

    public function weight()
    {
        $weight = 0;
        foreach($this->booking as $booking)
        {
            foreach($booking->colis as $colis)
            {
                $weight += $colis->weight();
            }
        }
        return $weight;
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class)->with('colis');
    }
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
