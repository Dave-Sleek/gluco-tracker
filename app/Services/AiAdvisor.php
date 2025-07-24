<?php

namespace App\Services;

use App\Models\MealLog;

class AiAdvisor
{
    public static function getMealAdvice(MealLog $meal)
    {
        $tags = $meal->tags ?? [];
        $glucose = $meal->glucose->original_value ?? null;

        if (!$glucose) {
            return "No glucose data found for this meal yet. Keep logging!";
        }

        if (in_array('High-Carb', $tags) && $glucose > 140) {
            return "⚠️ Your blood sugar rose after this high-carb meal. Consider pairing carbs with protein or fiber.";
        }

        if (in_array('Added Sugar', $tags) && $glucose > 160) {
            return "🍬 Elevated glucose may be linked to sugary foods. Try limiting desserts or sweetened drinks.";
        }

        if (in_array('Fiber-Rich', $tags) && $glucose < 120) {
            return "✅ Great choice! Fiber-rich meals may help stabilize glucose levels.";
        }

        return "No concerning patterns for this meal. Keep up the good tracking!";
    }
}
