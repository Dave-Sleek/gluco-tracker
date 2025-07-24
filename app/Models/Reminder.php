<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'remindars'; // custom table name

    protected $fillable = [
        'user_id',
        'subject',
        'body',
        'scheduled_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
