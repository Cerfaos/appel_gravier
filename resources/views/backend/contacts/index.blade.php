@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Contacts</h1>
            <p class="text-gray-600 mt-2">Gérez tous les messages de contact reçus</p>
        </div>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-4 gap-4 text-center">
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-500">Total</div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['new'] }}</div>
                <div class="text-sm text-gray-500">Nouveaux</div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="text-2xl font-bold text-green-600">{{ $stats['processed'] }}</div>
                <div class="text-sm text-gray-500">Traités</div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="text-2xl font-bold text-gray-600">{{ $stats['today'] }}</div>
                <div class="text-sm text-gray-500">Aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg p-6 mb-6 shadow-sm border border-gray-200">
        <form method="GET" class="flex gap-4 items-end">
            <!-- Search -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nom, email, sujet..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous</option>
                    <option value="nouveau" {{ request('status') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                    <option value="lu" {{ request('status') == 'lu' ? 'selected' : '' }}>Lu</option>
                    <option value="traite" {{ request('status') == 'traite' ? 'selected' : '' }}>Traité</option>
                    <option value="archive" {{ request('status') == 'archive' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
            
            <!-- Actions -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Filtrer
                </button>
                <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Contacts Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <form id="bulk-form" method="POST" action="{{ route('admin.contacts.bulk-action') }}">
            @csrf
            
            <!-- Bulk Actions Bar -->
            <div class="border-b border-gray-200 p-4 bg-gray-50 hidden" id="bulk-actions">
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">Actions groupées :</span>
                    <select name="action" class="px-3 py-1 text-sm border border-gray-300 rounded">
                        <option value="">Choisir une action</option>
                        <option value="mark_read">Marquer comme lu</option>
                        <option value="mark_processed">Marquer comme traité</option>
                        <option value="archive">Archiver</option>
                        <option value="delete">Supprimer</option>
                    </select>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Appliquer
                    </button>
                    <button type="button" onclick="clearSelection()" class="px-3 py-1 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                        Annuler
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="w-8 px-4 py-3">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Statut</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Contact</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Sujet</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 {{ $contact->isNew() ? 'bg-blue-50' : '' }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" class="contact-checkbox rounded border-gray-300">
                            </td>
                            
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $contact->status == 'nouveau' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $contact->status == 'lu' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $contact->status == 'traite' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $contact->status == 'archive' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ ucfirst($contact->status) }}
                                </span>
                            </td>
                            
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $contact->name }}</div>
                                <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                                @if($contact->phone)
                                    <div class="text-xs text-gray-400">{{ $contact->phone }}</div>
                                @endif
                            </td>
                            
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-900 font-medium">{{ $contact->subject }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ Str::limit($contact->message, 60) }}</div>
                            </td>
                            
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-900">{{ $contact->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $contact->created_at->format('H:i') }}</div>
                            </td>
                            
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                       class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Voir
                                    </a>
                                    
                                    @if(!$contact->isRead())
                                    <form method="POST" action="{{ route('admin.contacts.update-status', $contact->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="lu">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full hover:bg-yellow-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Marquer lu
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-lg font-medium">Aucun contact trouvé</p>
                                    <p class="text-sm">Les messages de contact apparaîtront ici</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const bulkForm = document.getElementById('bulk-form');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkActions();
    });

    // Individual checkbox functionality
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }

        // Update select all checkbox state
        selectAll.checked = checkedBoxes.length === checkboxes.length;
        selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;
    }

    // Bulk form submission
    bulkForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
        const action = document.querySelector('select[name="action"]').value;
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un contact.');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            alert('Veuillez choisir une action.');
            return;
        }

        if (action === 'delete') {
            if (!confirm('Êtes-vous sûr de vouloir supprimer les contacts sélectionnés ?')) {
                e.preventDefault();
            }
        }
    });
});

function clearSelection() {
    document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('select-all').checked = false;
    document.getElementById('bulk-actions').classList.add('hidden');
}
</script>

@endsection