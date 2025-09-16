<?php

namespace App\Filament\Resources\PreOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PreOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                    
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewing' => 'info',
                        'sourcing' => 'primary',
                        'sourced' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Pending Review',
                        'reviewing' => 'Under Review',
                        'sourcing' => 'Being Sourced',
                        'sourced' => 'Item Sourced',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                        default => ucfirst($state)
                    }),
                    
                TextColumn::make('estimated_price')
                    ->label('Est. Price')
                    ->money('MVR')
                    ->sortable(),
                    
                TextColumn::make('final_price')
                    ->label('Final Price')
                    ->money('MVR')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'reviewing' => 'Under Review',
                        'sourcing' => 'Being Sourced',
                        'sourced' => 'Item Sourced',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
