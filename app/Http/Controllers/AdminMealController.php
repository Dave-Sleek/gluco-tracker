<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\Storage;


class AdminMealController extends Controller
{
    public function index()
    {
        $meals = Meal::orderBy('created_at', 'desc')->get();
        return view('admin.manage-meals', compact('meals'));
    }

    public function edit(Meal $meal)
    {
        return view('admin.edit-meal', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|in:balanced,low_glycemic,energy_boost',
            'carbs' => 'required|numeric',
            'fiber' => 'required|numeric',
            'protein' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        // Update image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if you want (optional):
            if ($meal->image_url) {
                $oldPath = str_replace('storage/', '', $meal->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('meals', 'public');
            $meal->image_url = 'storage/' . $path;
        }

        // Update other fields
        $meal->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'nutrients' => [
                'carbs' => (float) $validated['carbs'],
                'fiber' => (float) $validated['fiber'],
                'protein' => (float) $validated['protein'],
            ],
        ]);

        return redirect()->route('admin.meals.edit', $meal->id)->with('message', '✅ Meal updated successfully!');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return redirect()->route('admin.meals.manage')->with('message', 'Meal deleted successfully!');
    }
}
