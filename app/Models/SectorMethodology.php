<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectorMethodology extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'title', 'description'];

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
