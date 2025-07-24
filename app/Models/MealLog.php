<?php

// app/Models/MealLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_description',
        'tags',
        'logged_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'logged_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

// app/Models/MealLog.php

public function nearestConversion()
{
    return \App\Models\Conversion::where('user_id', $this->user_id)
        ->where('original_unit', 'mg/dL') // or whatever unit marks glucose
        ->orderByRaw("ABS(TIMESTAMPDIFF(MINUTE, converted_at, '{$this->logged_at}'))")
        ->first();
}

}
