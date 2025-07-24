<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Optional: show confirmation page
    public function confirm()
    {
        return view('DeleteAccount.index');
    }

    // Deletes the authenticated user's account
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Optionally: detach relationships, clean up related data, etc.

        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/goodbye'); // Create a simple Blade page to say farewell if you'd like
    }
}
