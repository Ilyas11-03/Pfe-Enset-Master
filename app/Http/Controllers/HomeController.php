<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function sendContactForm(ContactFormRequest $request)
    {
        // Validate the data
        $data = $request->validated();

        // Save the contact data to the database
        Contact::create([
            'full_name' => $data['fullName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['userMessage'],
        ]);

        // Send the email
        Mail::send('emails.contact', $data, function ($message) {
            $message->to('contact@mygym.ma')
                ->subject('Contact Form Submission');
        });

        return back()->with('success', 'Thank you for your message. We will get back to you shortly.');
    }
}
