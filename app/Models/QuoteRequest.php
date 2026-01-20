<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'phone',
        'email',
        'service_type',
        'budget_range',
        'budget_range_id',
        'project_description',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getServiceTypeNameAttribute(): string
    {
        return match ($this->service_type) {
            'financial' => 'القوائم المالية',
            'integration' => 'خدمات تكامل الأنظمة',
            'facility' => 'إدارة المرافق',
            default => $this->service_type,
        };
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'قيد الانتظار',
            'reviewed' => 'تمت المراجعة',
            'quoted' => 'تم إرسال العرض',
            'rejected' => 'مرفوض',
            default => $this->status,
        };
    }

    /**
     * Get the budget range for this quote request
     */
    public function budgetRange()
    {
        return $this->belongsTo(BudgetRange::class);
    }
}
