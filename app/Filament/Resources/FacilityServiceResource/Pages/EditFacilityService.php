<?php

namespace App\Filament\Resources\FacilityServiceResource\Pages;

use App\Filament\Resources\FacilityServiceResource;
use Filament\Resources\Pages\EditRecord;

class EditFacilityService extends EditRecord
{
    protected static string $resource = FacilityServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
