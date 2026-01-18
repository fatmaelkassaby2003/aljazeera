<?php

namespace App\Filament\Resources\FinancialServiceResource\Pages;

use App\Filament\Resources\FinancialServiceResource;
use Filament\Resources\Pages\ListRecords;

class ListFinancialServices extends ListRecords
{
    protected static string $resource = FinancialServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
