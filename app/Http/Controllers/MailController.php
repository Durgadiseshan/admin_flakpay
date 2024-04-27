<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloEmail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate request data if needed
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ]);

        // Extract data from the request
        $emailData = [
            'from' => 'sender@example.com',
            'view' => 'emails.email_template', 
        ];

        // Create a new instance of the HelloEmail Mailable
        $email = new HelloEmail($emailData);

        // Try sending the email
        try {
            Mail::to($request->email)->send($email);
        } catch (\Exception $e) {
            // Return an error response if there's an exception
            return response()->json(['error' => 'Oops! There was some error sending the email.'], 500);
        }

        // Return a success response if email was sent successfully
        return response()->json(['message' => 'Email has been sent successfully.'], 200);
    }
}
