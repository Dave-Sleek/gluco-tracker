<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\MealRecommender;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MealSuggestions extends Component
{
    public $meals;

    public function mount()
    {
        $user = Auth::user();

        if (!$user) {
            // No authenticated user — fallback
            $this->meals = MealRecommender::defaultSuggestions();
            return;
        }

        // If user explicitly chose a meal preference, honor it
        if ($user->meal_preference) {
            $this->meals = MealRecommender::suggest($user);
            return;
        }

        // If user has glucose data, go health-based
        if ($user->glucose) {
            $this->meals = MealRecommender::suggest($user);
        } else {
            // Fallback: show generic meals
            $this->meals = MealRecommender::defaultSuggestions();
        }
    }

    public function swap()
    {
        $user = Auth::user();

        if (!$user) {
            $this->meals = MealRecommender::defaultSuggestions();
            return;
        }

        if ($user->meal_preference || $user->glucose) {
            $this->meals = MealRecommender::suggest($user);
        } else {
            $this->meals = MealRecommender::defaultSuggestions();
        }

        logger('🔁 Meal suggestions swapped for user: ' . $user->id);
    }

    public function addToPlan($mealId)
    {
        \App\Models\MealPlan::create([
            'user_id' => Auth::id(),
            'meal_id' => $mealId,
            'scheduled_for' => now(), // 🔧 You can allow user to pick a date later
        ]);

        session()->flash('message', '✅ Meal added to your plan!');
    }

    public function render()
    {
        return view('livewire.meal-suggestions');
    }
}
