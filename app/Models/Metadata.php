<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $fillable = [
        "key",
        "value",
        "admin_id"
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
