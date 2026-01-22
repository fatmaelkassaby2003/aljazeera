<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialService extends Model
{
    use HasFactory;

    protected $table = 'financial_services';

    protected $fillable = [
        'name',
        'price',
        'description',
        'important_note',
        'work_mechanism',
        'financial_periods',
        'icon',
    ];

    protected $casts = [
        'work_mechanism' => 'array',
        'financial_periods' => 'array',
        'price' => 'decimal:2',
    ];

    public function types()
    {
        return $this->morphMany(ServiceType::class, 'serviceable');
    }
}
