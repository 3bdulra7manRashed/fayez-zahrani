<?php

namespace App\Filament\Resources\BookMessages\Pages;

use App\Filament\Resources\BookMessages\BookMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookMessage extends CreateRecord
{
    protected static string $resource = BookMessageResource::class;
}
