<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    use HasFactory;

    protected $fillable = ['region', 'country', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
