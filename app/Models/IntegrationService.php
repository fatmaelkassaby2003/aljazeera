<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationService extends Model
{
    use HasFactory;

    protected $table = 'integration_services';

    protected $fillable = [
        'name',
        'price',
        'description',
        'important_note',
        'types',
        'icon',
    ];

    protected $casts = [
        'types' => 'array',
        'price' => 'decimal:2',
    ];
}
