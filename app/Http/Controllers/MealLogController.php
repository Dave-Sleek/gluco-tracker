<?php

// app/Http/Controllers/MealLogController.php

namespace App\Http\Controllers;

use App\Models\MealLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AiAdvisor;

class MealLogController extends Controller
{
    public function index()
    {
        $mealLogs = MealLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->get()
            ->map(function ($meal) {
                $meal->recommendation = AiAdvisor::getMealAdvice($meal);
                $meal->glucose = $meal->nearestConversion();
                return $meal;
            });

        return view('meal-log.index', compact('mealLogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'meal_description' => 'required|string|max:1000',
        ]);

        $tags = getSmartTags($request->meal_description);

        $meal = MealLog::create([
            'user_id' => Auth::id(),
            'meal_description' => $request->meal_description,
            'tags' => $tags,
            'logged_at' => now(),
        ]);

        return redirect()->route('meal-log.index')->with('success', 'Meal logged!');
    }

    public function destroy(MealLog $meal)
    {
        if ($meal->user_id === Auth::id()) {
            $meal->delete();
        }

        return redirect()->route('meal-log.index')->with('success', 'Meal removed!');
    }
}

function getSmartTags($mealText)
{
    $tags = [];
    $mealText = strtolower($mealText);

    $highCarb = ['rice', 'pasta', 'bread', 'noodles', 'banana', 'potato'];
    $fiberRich = ['broccoli', 'lentils', 'whole grain', 'nuts', 'beans', 'berries'];
    $highProtein = ['egg', 'chicken', 'beef', 'fish', 'tofu'];
    $sugary = ['soda', 'candy', 'dessert', 'cake', 'ice cream'];

    foreach ($highCarb as $food) {
        if (str_contains($mealText, $food)) $tags[] = 'High-Carb';
    }

    foreach ($fiberRich as $food) {
        if (str_contains($mealText, $food)) $tags[] = 'Fiber-Rich';
    }

    foreach ($highProtein as $food) {
        if (str_contains($mealText, $food)) $tags[] = 'Protein-Packed';
    }

    foreach ($sugary as $food) {
        if (str_contains($mealText, $food)) $tags[] = 'Added Sugar';
    }

    return array_unique($tags);
}
