<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'read_at'
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function isNew(): bool
    {
        return $this->status === 'nouveau';
    }

    public function isRead(): bool
    {
        return in_array($this->status, ['lu', 'traite', 'archive']);
    }

    public function markAsRead(): void
    {
        if ($this->status === 'nouveau') {
            $this->update([
                'status' => 'lu',
                'read_at' => now()
            ]);
        }
    }

    public function markAsProcessed(): void
    {
        $this->update(['status' => 'traite']);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archive']);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'nouveau');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'lu');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'traite');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archive');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'nouveau' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Nouveau</span>',
            'lu' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Lu</span>',
            'traite' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Traité</span>',
            'archive' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Archivé</span>',
        };
    }
}
