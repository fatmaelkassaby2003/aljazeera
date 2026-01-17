<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'highlights',
        'image'
    ];

    protected $casts = [
        'highlights' => 'array', // تحويل JSON إلى array تلقائياً
    ];

    // accessor للحصول على المسار الكامل للصورة
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }
        return null;
    }
}
