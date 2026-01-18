<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'message',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'new' => 'جديدة',
            'read' => 'مقروءة',
            'replied' => 'تم الرد',
            'archived' => 'مؤرشفة',
            default => $this->status,
        };
    }
}
