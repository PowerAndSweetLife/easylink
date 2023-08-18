<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        "username","firstname","lastname","contact","email","password", "localization_id","address", "phone"
    ];

    public function fullname(): string
    {
        return $this->firstname ." ". $this->lastname;
    }
    public function shortName(): string
    {
        return $this->lastname;
    }
    
    public function address(string $packageSize): string
    {
        $address = json_decode($this->address);
        if($packageSize === 'small')
        {
            return $address->small;
        }
        return $address->regular;
    }

    public function localization()
    {
        return $this->belongsTo(Localization::class);
    }
}
