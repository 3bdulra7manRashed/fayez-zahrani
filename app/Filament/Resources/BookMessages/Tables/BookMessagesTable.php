<?php

namespace App\Filament\Resources\BookMessages\Tables;

use App\Models\BookMessage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BookMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label('الكتاب')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('name')
                    ->label('اسم المرسل')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_read')
                    ->label('تمت القراءة')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('حالة الرسالة')
                    ->trueLabel('الرسائل المقروءة')
                    ->falseLabel('الرسائل غير المقروءة')
                    ->placeholder('جميع الرسائل'),
            ])
            ->recordActions([
                Action::make('markAsRead')
                    ->label('تحديد كمقروء')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (BookMessage $record): bool => !$record->is_read)
                    ->action(function (BookMessage $record) {
                        $record->update(['is_read' => true]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
