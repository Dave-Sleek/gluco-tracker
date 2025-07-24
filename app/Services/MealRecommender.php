<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\User;

class MealRecommender
{
    public static function suggest(User $user)
    {
        // 🥇 Step 1: Prioritize user-defined preference
        if ($user->meal_preference) {
            return Meal::where('category', $user->meal_preference)
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        // 🧠 Step 2: Use most recent health conversion data
        $conversion = $user->conversions()->orderBy('converted_at', 'desc')->first();

        if ($conversion && $conversion->glucose > 160) {
            return Meal::where('category', 'low_glycemic')
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        if ($conversion && $conversion->fatigue) {
            return Meal::where('category', 'energy_boost')
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        // 🛡️ Step 3: Default fallback (balanced meals)
        return Meal::where('category', 'balanced')
            ->inRandomOrder()
            ->take(3)
            ->get();
    }

    public static function defaultSuggestions()
    {
        // 🚦 Safe meals for users without profile/conversion data
        return Meal::where('is_generic', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }
}
