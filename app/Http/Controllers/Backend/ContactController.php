<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display all contacts
     */
    public function index(Request $request)
    {
        $query = Contact::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);
        $stats = $this->getContactStats();

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Show a specific contact
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Mark as read if it's new
        if ($contact->isNew()) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact status
     */
    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:nouveau,lu,traite,archive',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $contact->admin_notes,
            'read_at' => $request->status !== 'nouveau' ? now() : $contact->read_at
        ]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Delete a contact
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact supprimé avec succès.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_processed,archive,delete',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        $contacts = Contact::whereIn('id', $request->contact_ids);

        switch ($request->action) {
            case 'mark_read':
                $contacts->update(['status' => 'lu', 'read_at' => now()]);
                $message = 'Contacts marqués comme lus.';
                break;
            case 'mark_processed':
                $contacts->update(['status' => 'traite']);
                $message = 'Contacts marqués comme traités.';
                break;
            case 'archive':
                $contacts->update(['status' => 'archive']);
                $message = 'Contacts archivés.';
                break;
            case 'delete':
                $contacts->delete();
                $message = 'Contacts supprimés.';
                break;
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', $message);
    }

    /**
     * Get contact statistics
     */
    private function getContactStats(): array
    {
        return [
            'total' => Contact::count(),
            'new' => Contact::new()->count(),
            'read' => Contact::read()->count(),
            'processed' => Contact::processed()->count(),
            'archived' => Contact::archived()->count(),
            'today' => Contact::whereDate('created_at', today())->count(),
            'this_week' => Contact::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'this_month' => Contact::whereMonth('created_at', now()->month)->count(),
        ];
    }
}
