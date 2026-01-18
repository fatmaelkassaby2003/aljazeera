<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'image',
        'description',
        'vision',
        'mission',
        'values',
    ];

    protected $casts = [
        'vision' => 'array',
        'mission' => 'array',
        'values' => 'array',
    ];
}
