<?php

namespace App\Filament\Resources\FinancialServiceResource\Pages;

use App\Filament\Resources\FinancialServiceResource;
use Filament\Resources\Pages\EditRecord;

class EditFinancialService extends EditRecord
{
    protected static string $resource = FinancialServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
