<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use Filament\Resources\Pages\Page;

class EditProfile extends Page
{
    protected static string $resource = ProfileResource::class;

    protected static string $view = 'filament.resources.[-none]-resource.pages.edit-profile';
}
