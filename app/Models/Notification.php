<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'message', 'status', 'sent_at'
    ];

    public $timestamps = false; // Or true if you're also using `updated_at`
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
