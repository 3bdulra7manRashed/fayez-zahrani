<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        // Helper to generate a slug in Arabic or transliterated
                        $slug = preg_replace('/\s+/u', '_', trim($state));
                        $slug = preg_replace('/[^A-Za-z0-9_\x{0600}-\x{06FF}]/u', '', $slug);
                        $set('slug', $slug);
                    }),
                TextInput::make('slug')
                    ->label('الرابط البديل (Slug)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->label('الوصف / النبذة')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('edition')
                    ->label('الطبعة'),
                TextInput::make('pages_count')
                    ->label('عدد الصفحات')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('dimensions')
                    ->label('المقاس (مثال: 14 × 21)'),
                TextInput::make('publisher')
                    ->label('الناشر'),
                DatePicker::make('published_at')
                    ->label('تاريخ النشر'),
                FileUpload::make('cover_path')
                    ->label('صورة الغلاف')
                    ->image()
                    ->directory('books')
                    ->required(),
                FileUpload::make('pdf_path')
                    ->label('ملف PDF للكتاب')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480)
                    ->directory('books')
                    ->required(),
                TextInput::make('views_count')
                    ->label('عدد المشاهدات')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('downloads_count')
                    ->label('عدد التحميلات')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
