<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'client_id', 'admin_id', 'is_read', 'sender'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
