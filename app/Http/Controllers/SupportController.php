<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function show()
    {
        return view('support.contact', [
            'adminPhone' => '+2348138809708',
            'adminEmail' => 'support@healthtracker.com',
            'whatsappNumber' => '2348138809708'
        ]);
    }

    public function submitSupport(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        DB::table('support_messages')->insert([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', '✅ Your support message has been submitted.');
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'feedback_type' => 'required|string|max:100',
            'message' => 'required|string'
        ]);

        DB::table('feedback')->insert([
            'user_id' => Auth::id(),
            'type' => $request->feedback_type,
            'message' => $request->message,
            'created_at' => now()
        ]);

        return redirect()->back()->with('feedback_success', '✅ Your feedback has been submitted.');
    }
}
