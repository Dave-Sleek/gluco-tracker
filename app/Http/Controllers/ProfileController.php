<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Display the profile edit form
    public function index()
    {
        $user = Auth::user();
        return view('Profile.index', compact('user'));
    }

    // Handle profile update
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notifications_enabled' => 'nullable|boolean',
        ]);
        
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->full_name = $validated['name'];
        $user->email = $validated['email'];
        $user->dob = $validated['dob'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        return redirect()->route('Profile')->with('success', 'Profile successfully updated!');
    }
    
}
