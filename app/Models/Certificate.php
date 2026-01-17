<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'issue_date',
        'issuing_authority',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];
}
