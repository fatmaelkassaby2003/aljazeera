<?php

namespace App\Filament\Resources\IntegrationServiceResource\Pages;

use App\Filament\Resources\IntegrationServiceResource;
use Filament\Resources\Pages\EditRecord;

class EditIntegrationService extends EditRecord
{
    protected static string $resource = IntegrationServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
