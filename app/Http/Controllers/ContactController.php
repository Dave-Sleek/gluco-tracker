<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

         // Save to database
            Contact::create($validated);

        // You can save to database, send mail, etc.
        Mail::to('sahobordavid@gmail.com')->send(new ContactMessageMail($validated));

        return back()->with('success', 'Thank you for reaching out! We will get back to you shortly.');
    }
}
