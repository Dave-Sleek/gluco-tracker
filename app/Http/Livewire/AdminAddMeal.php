<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Meal;
use Livewire\WithFileUploads;

class AdminAddMeal extends Component
{
    use WithFileUploads;

    public $name, $description, $category;
    public $image; // uploaded file
    public $carbs, $fiber, $protein;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'category' => 'required|in:balanced,low_glycemic,energy_boost',
        'image' => 'required|image|max:2048', // 2MB max
        'carbs' => 'required|numeric',
        'fiber' => 'required|numeric',
        'protein' => 'required|numeric',
    ];

    protected $messages = [
        'name.required' => 'Please enter a meal name.',
        'description.required' => 'Meal description is required.',
        'category.required' => 'Select a valid category.',
        'image.required' => 'Upload an image of the meal.',
        'image.image' => 'File must be an image.',
        'carbs.required' => 'Carbohydrate value is required.',
        'fiber.required' => 'Fiber value is required.',
        'protein.required' => 'Protein value is required.',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function getTotalNutrientsProperty()
    {
        return (float) ($this->carbs ?? 0) + (float) ($this->fiber ?? 0) + (float) ($this->protein ?? 0);
    }

    public function submit()
    {
        $this->validate();

        $path = $this->image->store('meals', 'public');

        Meal::create([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'image_url' => 'storage/' . $path,
            'nutrients' => [
                'carbs' => (float) $this->carbs,
                'fiber' => (float) $this->fiber,
                'protein' => (float) $this->protein,
            ],
        ]);

        session()->flash('message', '✅ Meal added successfully!');
        $this->reset(['name', 'description', 'category', 'carbs', 'fiber', 'protein', 'image']);
    }

    public function saveAndReset()
    {
        $this->submit(); // reuse submit logic
    }

    public function render()
    {
        return view('livewire.admin-add-meal');
    }
}
