<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlucoseLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reading', 'recorded_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: add getLatestReading method
    public static function getLatestReading($userId)
    {
        return self::where('user_id', $userId)
            ->latest('recorded_at')
            ->first();
    }
}
