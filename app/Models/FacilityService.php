<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityService extends Model
{
    use HasFactory;

    protected $table = 'facility_services';

    protected $fillable = [
        'name',
        'price',
        'description',
        'important_note',
        'icon',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function types()
    {
        return $this->morphMany(ServiceType::class, 'serviceable');
    }
}
