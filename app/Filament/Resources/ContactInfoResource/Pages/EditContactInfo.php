<?php

namespace App\Filament\Resources\ContactInfoResource\Pages;

use App\Filament\Resources\ContactInfoResource;
use App\Models\ContactInfo;
use Filament\Resources\Pages\EditRecord;

class EditContactInfo extends EditRecord
{
    protected static string $resource = ContactInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(int | string $record = null): void
    {
        // Always edit the first (and only) record, ignore the $record parameter
        $this->record = ContactInfo::first();
        
        if (!$this->record) {
            // Create default record if doesn't exist
            $this->record = ContactInfo::create([
                'phone' => '+966 50 123 4567',
                'email' => 'info@example.com',
                'description' => '',
            ]);
        }

        $this->fillForm();
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
