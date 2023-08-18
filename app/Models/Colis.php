<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colis extends Model
{
    use HasFactory;

    const SEND = 'send';
    const RECEIVED = 'receive';
    const ONBOARD = 'on board';
    const FLOATING = 'floating';
    const TAMATAVE = 'tamatave';
    const TANA = 'Tanà';
    const READY_TO_DELIVERED = 'Ready to delivered';
    const DELIVERED = "delivered";

    protected $guarded = [];

    public function volume(): float
    {
        $dimensions = json_decode($this->dimensions);
        $cbm = 0;
        foreach($dimensions as $dim)
        {
            $cbm += (int)$dim->count * (float)$dim->width * (float)$dim->height * (float)$dim->length;
        }
        return round( $cbm * pow(10, -6) , 2);
    }

    public function number(): int
    {
        $dimensions = json_decode($this->dimensions);
        $nb = 0;
        foreach($dimensions as $dim)
        {
            $nb += (int)$dim->count;
        }
        return $nb;
    }
    public function weight(): float
    {
        $dimensions = json_decode($this->dimensions);
        $weight = 0;
        foreach($dimensions as $dim)
        {
            $weight += (int)$dim->count * (float)$dim->weight;
        }
        return $weight;
    }

    public function dimensions(): array
    {
        return json_decode($this->dimensions);
    }

    public function description(): array 
    {
        return explode(",", $this->description);
    }

    public function attachments(): array
    {
        if(is_null($this->attachments))
        {
            return [];
        }
        return json_decode($this->attachments);
    }
    
    public function sendAt()
    {
        return new DateTime($this->send_at);
    }

    public function size()
    {
        if($this->volume() >= 1)
        {
            return __('Regular');
        }
        return __('Small');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    
    // public function expedition()
    // {
    //     return $this->belongsTo(Expedition::class)->with('booking');
    // }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
