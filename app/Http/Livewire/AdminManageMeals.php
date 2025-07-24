<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Meal;

class AdminManageMeals extends Component
{
    public $search = '';
    public $editingMeal = null;
    public $triggerSearch = false;

    // ✅ Reactive meals list
    public function getMealsProperty()
    {
        return Meal::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('category', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function searchMeals()
    {
        $this->triggerSearch = true; // optional, if you want to control visibility
    }

    // ✅ Trigger edit mode
    public function edit(Meal $meal)
    {
        $this->editingMeal = $meal;
    }

    // ✅ Save updates (if editingMeal is set)
    public function update()
    {
        if ($this->editingMeal) {
            $this->editingMeal->save();
            session()->flash('message', 'Meal updated!');
            $this->editingMeal = null;
        }
    }

    // ✅ Delete and rely on reactive data (no need to call mount())
    public function delete(Meal $meal)
    {
        $meal->delete();
        session()->flash('message', 'Meal removed!');
    }

    // ✅ Render the Livewire Blade view
    public function render()
    {
        return view('livewire.admin-manage-meals');
    }
}
