<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    // accessor للحصول على المسار الكامل للوجو
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return asset($this->logo);
        }
        return null;
    }
}
