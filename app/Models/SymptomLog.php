<?php

// app/Models/SymptomLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SymptomLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'logged_at',
        'symptom',
        'notes',
        'glucose_log_id',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];


    public function nearestGlucose()
    {
        return GlucoseLog::where('user_id', $this->user_id)
            ->orderByRaw("ABS(TIMESTAMPDIFF(MINUTE, recorded_at, '{$this->logged_at}'))")
            ->first();
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function glucoseLog()
    {
        return $this->belongsTo(GlucoseLog::class);
    }
}
