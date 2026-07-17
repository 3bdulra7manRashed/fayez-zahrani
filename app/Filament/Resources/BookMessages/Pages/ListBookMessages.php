<?php

namespace App\Filament\Resources\BookMessages\Pages;

use App\Filament\Resources\BookMessages\BookMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookMessages extends ListRecords
{
    protected static string $resource = BookMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
