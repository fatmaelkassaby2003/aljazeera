<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'min_amount',
        'max_amount',
        'is_active',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get all quote requests with this budget range
     */
    public function quoteRequests()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    /**
     * Scope to get only active ranges
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted display label
     */
    public function getDisplayLabelAttribute()
    {
        if ($this->min_amount && $this->max_amount) {
            return number_format($this->min_amount, 0) . ' - ' . number_format($this->max_amount, 0) . ' ر.س';
        } elseif ($this->min_amount) {
            return 'أكثر من ' . number_format($this->min_amount, 0) . ' ر.س';
        } elseif ($this->max_amount) {
            return 'أقل من ' . number_format($this->max_amount, 0) . ' ر.س';
        }
        return $this->label;
    }
}
