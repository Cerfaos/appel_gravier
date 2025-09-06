CERFAOS - NOUVEAU MESSAGE DE CONTACT
=====================================

📩 Un nouveau message de contact vient d'être reçu sur votre plateforme Cerfaos.

INFORMATIONS DU CONTACT
-----------------------
Nom: {{ $contact->name }}
Email: {{ $contact->email }}
@if($contact->phone)Téléphone: {{ $contact->phone }}
@endifDate: {{ $contact->created_at->format('d/m/Y à H:i') }}

SUJET
-----
{{ $contact->subject }}

MESSAGE
-------
{{ $contact->message }}

ACTIONS
-------
- Voir dans l'admin: {{ $adminUrl }}
- Répondre par email: {{ $contact->email }}

INFORMATIONS TECHNIQUES
-----------------------
ID: #{{ $contact->id }}
IP: {{ $contact->ip_address ?? 'N/A' }}
Statut: {{ ucfirst($contact->status) }}
User Agent: {{ $contact->user_agent ?? 'N/A' }}

Cette notification a été envoyée automatiquement par la plateforme Cerfaos.
Pour gérer ce contact, rendez-vous sur: {{ $adminUrl }}