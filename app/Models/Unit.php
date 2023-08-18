<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'alias', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
