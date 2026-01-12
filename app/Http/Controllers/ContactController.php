<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'email.required' => 'Votre email est requis.',
            'email.email' => 'Veuillez entrer un email valide.',
            'message.required' => 'Votre message est requis.',
            'message.min' => 'Votre message doit contenir au moins 10 caractères.',
            'message.max' => 'Votre message ne peut pas dépasser 1000 caractères.',
        ]);

        try {
            // Envoi de l'email
            Mail::send([], [], function ($message) use ($validated) {
                // Configuration de l'email
                $message->to('mail.contact.amigo.amiens@gmail.com')
                    ->subject('Nouveau message de contact - AmiGo')
                    ->html("
                        <h2>Nouveau message de contact</h2>
                        <p><strong>Email:</strong> {$validated['email']}</p>
                        <p><strong>Message:</strong></p>
                        <p>{$validated['message']}</p>
                        <hr>
                        <p><small>Envoyé depuis le formulaire de contact AmiGo</small></p>
                    ");
            });

            return back()->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
        } catch (\Exception $e) {
            Log::error('Erreur envoi email contact: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.');
        }
    }
}
