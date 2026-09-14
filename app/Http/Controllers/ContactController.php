<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'captcha' => 'required|numeric'
        ]);

        if ($request->captcha != session('captcha_result')) {
            return back()->withInput()->withErrors(['captcha' => 'Invalid captcha answer. Please try again.']);
        }

        \App\Models\ContactInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Clear captcha session after use
        session()->forget('captcha_result');

        return back()->with('success', 'Your inquiry has been logged successfully. We will get back to you soon!');
    }
}
