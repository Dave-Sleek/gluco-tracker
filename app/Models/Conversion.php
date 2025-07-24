<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'user_id',
        'original_value',
        'original_unit',
        'converted_value',
        'converted_unit',
        'type',
        'label',
        'converted_at'
    ];
    

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
