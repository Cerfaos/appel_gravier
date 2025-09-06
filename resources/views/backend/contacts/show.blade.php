@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour aux contacts
                </a>
                <div class="h-6 w-px bg-gray-300"></div>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                    {{ $contact->status == 'nouveau' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $contact->status == 'lu' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $contact->status == 'traite' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $contact->status == 'archive' ? 'bg-gray-100 text-gray-800' : '' }}
                ">
                    {{ ucfirst($contact->status) }}
                </span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $contact->subject }}</h1>
            <p class="text-gray-600 mt-1">Message reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex gap-2">
            @if($contact->status !== 'archive')
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact->id) }}" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="archive">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l4 4 4-4m0 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6"/>
                        </svg>
                        Archiver
                    </button>
                </form>
            @endif
            
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Message Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations du contact</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $contact->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <a href="mailto:{{ $contact->email }}" class="mt-1 text-sm text-blue-600 hover:text-blue-800 font-medium">{{ $contact->email }}</a>
                        </div>
                        @if($contact->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <a href="tel:{{ $contact->phone }}" class="mt-1 text-sm text-blue-600 hover:text-blue-800 font-medium">{{ $contact->phone }}</a>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Message</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Reply (Email Composition) -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Réponse rapide</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">À</label>
                        <input type="email" value="{{ $contact->email }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                        <input type="text" value="Re: {{ $contact->subject }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea rows="6" placeholder="Votre réponse..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y"></textarea>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-xs text-gray-500">Cette fonctionnalité ouvrira votre client email</p>
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}&body=Bonjour {{ $contact->name }},%0D%0A%0D%0AMerci pour votre message.%0D%0A%0D%0ACordialement,%0D%0AL'équipe Cerfaos" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Répondre
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Management -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion du statut</h3>
                
                <form method="POST" action="{{ route('admin.contacts.update-status', $contact->id) }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="nouveau" {{ $contact->status == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="lu" {{ $contact->status == 'lu' ? 'selected' : '' }}>Lu</option>
                                <option value="traite" {{ $contact->status == 'traite' ? 'selected' : '' }}>Traité</option>
                                <option value="archive" {{ $contact->status == 'archive' ? 'selected' : '' }}>Archivé</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes administratives</label>
                            <textarea name="admin_notes" rows="4" placeholder="Ajoutez vos notes..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y">{{ $contact->admin_notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <!-- Technical Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations techniques</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="font-mono text-gray-900">#{{ $contact->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">IP:</span>
                        <span class="font-mono text-gray-900">{{ $contact->ip_address ?? 'N/A' }}</span>
                    </div>
                    
                    @if($contact->read_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Lu le:</span>
                        <span class="text-gray-900">{{ $contact->read_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    
                    <div class="pt-2 border-t border-gray-200">
                        <span class="text-gray-600 block mb-2">User Agent:</span>
                        <span class="text-xs text-gray-500 break-all">{{ $contact->user_agent ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Timeline -->
            @if($contact->admin_notes || $contact->read_at)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique</h3>
                
                <div class="space-y-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Message reçu</p>
                            <p class="text-xs text-gray-500">{{ $contact->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($contact->read_at)
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Message lu</p>
                            <p class="text-xs text-gray-500">{{ $contact->read_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($contact->updated_at != $contact->created_at)
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Dernière modification</p>
                            <p class="text-xs text-gray-500">{{ $contact->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection