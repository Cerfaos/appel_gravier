<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact - Cerfaos</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #475569 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header .subtitle {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px 20px;
        }
        .alert {
            background-color: #d4af37;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .contact-info {
            background-color: #f8f9fa;
            border-left: 4px solid #d4af37;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .contact-info h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
        }
        .message-section {
            margin: 25px 0;
        }
        .message-section h4 {
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .message-content {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            white-space: pre-line;
            font-size: 14px;
            line-height: 1.6;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #d4af37 0%, #cd7f32 100%);
            color: white;
        }
        .btn-secondary {
            background-color: #64748b;
            color: white;
        }
        .technical-info {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 25px;
            font-size: 12px;
            color: #64748b;
        }
        .technical-info h5 {
            margin: 0 0 10px 0;
            color: #475569;
            font-size: 13px;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 12px;
        }
        .footer a {
            color: #d4af37;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .btn {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏔️ Nouveau message de contact</h1>
            <p class="subtitle">Plateforme Cerfaos - Gestion des contacts</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert">
                📩 Un nouveau message de contact vient d'être reçu et nécessite votre attention.
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <h3>Informations du contact</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value">{{ $contact->name }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Adresse email</span>
                        <span class="info-value">{{ $contact->email }}</span>
                    </div>
                    
                    @if($contact->phone)
                    <div class="info-item">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $contact->phone }}</span>
                    </div>
                    @endif
                    
                    <div class="info-item">
                        <span class="info-label">Date de réception</span>
                        <span class="info-value">{{ $contact->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Sujet</span>
                    <span class="info-value" style="font-size: 16px; font-weight: 600;">{{ $contact->subject }}</span>
                </div>
            </div>

            <!-- Message Content -->
            <div class="message-section">
                <h4>💬 Message</h4>
                <div class="message-content">{{ $contact->message }}</div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ $adminUrl }}" class="btn btn-primary">
                    👀 Voir dans l'admin
                </a>
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}&body=Bonjour {{ $contact->name }},%0D%0A%0D%0AMerci pour votre message concernant nos aventures outdoor.%0D%0A%0D%0ACordialement,%0D%0AL'équipe Cerfaos" class="btn btn-secondary">
                    📧 Répondre directement
                </a>
            </div>

            <!-- Technical Information -->
            <div class="technical-info">
                <h5>Informations techniques</h5>
                <strong>ID:</strong> #{{ $contact->id }}<br>
                <strong>IP:</strong> {{ $contact->ip_address ?? 'N/A' }}<br>
                <strong>User Agent:</strong> {{ Str::limit($contact->user_agent ?? 'N/A', 60) }}<br>
                <strong>Statut:</strong> {{ ucfirst($contact->status) }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Cette notification a été envoyée automatiquement par la plateforme Cerfaos.<br>
                <a href="{{ $adminUrl }}">Gérer ce contact dans l'administration</a>
            </p>
        </div>
    </div>
</body>
</html>