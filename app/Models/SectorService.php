<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectorService extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'service'];

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
