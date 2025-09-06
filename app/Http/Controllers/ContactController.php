<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactNotificationMail;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a new contact message
     */
    public function store(ContactRequest $request)
    {
        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'nouveau',
            ]);

            // Send notification email to admin
            try {
                Mail::to(config('mail.admin_email', 'cerfaos@gmail.com'))
                    ->send(new ContactNotificationMail($contact));
            } catch (\Exception $e) {
                // Log email error but don't fail the contact creation
                Log::error('Failed to send contact notification email: ' . $e->getMessage());
            }

            return redirect()->route('contact.index')
                ->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');

        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return redirect()->route('contact.index')
                ->with('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.')
                ->withInput();
        }
    }
}
