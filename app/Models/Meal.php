<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'nutrients',
        'image_url',
    ];

    protected $casts = [
        'nutrients' => 'array',
    ];

    /**
     * Optional: If you're tracking when meals are assigned to a plan
     */
    public function plans()
    {
        return $this->hasMany(MealPlan::class);
    }
}
