<?php

namespace App\Filament\Resources\BookMessages;

use App\Filament\Resources\BookMessages\Pages\CreateBookMessage;
use App\Filament\Resources\BookMessages\Pages\EditBookMessage;
use App\Filament\Resources\BookMessages\Pages\ListBookMessages;
use App\Filament\Resources\BookMessages\Schemas\BookMessageForm;
use App\Filament\Resources\BookMessages\Tables\BookMessagesTable;
use App\Models\BookMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BookMessageResource extends Resource
{
    protected static ?string $model = BookMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'الرسائل الواردة';

    protected static ?string $pluralModelLabel = 'الرسائل الواردة';

    protected static ?string $modelLabel = 'رسالة';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_read', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return BookMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookMessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookMessages::route('/'),
            'create' => CreateBookMessage::route('/create'),
            'edit' => EditBookMessage::route('/{record}/edit'),
        ];
    }
}
