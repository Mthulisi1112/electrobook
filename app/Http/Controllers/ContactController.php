<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }
    
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        
        // Send email logic here
        Mail::to('support@electrobook.test')->send(new ContactMail($request->all()));
        
        return back()->with('success', 'Thank you for contacting us. We\'ll respond within 24 hours.');
    }
}