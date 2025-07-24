<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'support_messages'; // 👈 Let Laravel know
    protected $fillable = ['user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
