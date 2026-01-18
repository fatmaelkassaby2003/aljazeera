<?php

namespace App\Filament\Resources\WorkMethodResource\Pages;

use App\Filament\Resources\WorkMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkMethod extends EditRecord
{
    protected static string $resource = WorkMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
