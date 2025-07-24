<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MealPreference extends Component
{
    public $mealPreference;

    public function mount()
    {
        $this->mealPreference = Auth::user()->meal_preference ?? 'balanced';
    }

    public function updatePreference()
    {
        Auth::user()->update(['meal_preference' => $this->mealPreference]);
        session()->flash('message', 'Meal preference updated!');
    }

    public function render()
    {
        return view('livewire.meal-preference');
    }
}
