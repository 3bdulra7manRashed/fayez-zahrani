<?php

namespace App\Filament\Resources\BookMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('book_id')
                    ->label('الكتاب المرتبط')
                    ->relationship('book', 'title')
                    ->required()
                    ->disabled(),
                TextInput::make('name')
                    ->label('اسم المرسل')
                    ->required()
                    ->disabled(),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->disabled(),
                Textarea::make('message')
                    ->label('نص الرسالة')
                    ->required()
                    ->columnSpanFull()
                    ->disabled(),
                Toggle::make('is_read')
                    ->label('تمت القراءة')
                    ->required(),
            ]);
    }
}
