<?php

namespace App\Filament\Resources\BookMessages\Pages;

use App\Filament\Resources\BookMessages\BookMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookMessage extends EditRecord
{
    protected static string $resource = BookMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
