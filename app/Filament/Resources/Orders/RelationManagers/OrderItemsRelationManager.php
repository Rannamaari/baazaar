<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('product.image_path')
                    ->label('Image')
                    ->disk('public')
                    ->size(60)
                    ->defaultImageUrl('/images/placeholder.png'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->formatStateUsing(function ($record) {
                        // Use product name if available, otherwise use stored name
                        return $record->product?->name ?? $record->name ?? 'Unknown Product';
                    })
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->formatStateUsing(fn($state) => 'MVR ' . number_format($state, 2))
                    ->sortable(),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Quantity')
                    ->alignCenter()
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('line_total')
                    ->label('Line Total')
                    ->formatStateUsing(fn($state) => 'MVR ' . number_format($state, 2))
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
