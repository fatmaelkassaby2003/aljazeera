<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points',
        'images',
        'items',
    ];

    protected $casts = [
        'points' => 'array',
        'images' => 'array',
        'items' => 'array',
    ];

    public function serviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
