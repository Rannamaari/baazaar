<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('order_items')
                    ->label('Products')
                    ->formatStateUsing(function ($record) {
                        if (!$record || !$record->orderItems || $record->orderItems->count() === 0) {
                            return 'No items';
                        }

                        $itemCount = $record->orderItems->count();

                        if ($itemCount === 1) {
                            $item = $record->orderItems->first();
                            // Use stored name as fallback if product doesn't exist
                            return $item->product?->name ?? $item->name ?? 'Unknown Product';
                        } else {
                            return $itemCount . ' different products';
                        }
                    })
                    ->limit(50)
                    ->tooltip(function ($record) {
                        if (!$record || !$record->orderItems || $record->orderItems->count() === 0) {
                            return null;
                        }

                        $items = $record->orderItems->map(function ($item) {
                            $productName = $item->product?->name ?? $item->name ?? 'Unknown Product';
                            return $productName . ' - Qty: ' . $item->qty . ' - Price: MVR ' . number_format($item->unit_price, 2);
                        })->toArray();

                        return implode("\n", $items);
                    }),

                TextColumn::make('item_count')
                    ->label('Items')
                    ->formatStateUsing(function ($record) {
                        if (!$record || !$record->orderItems) {
                            return '0';
                        }

                        return $record->orderItems->sum('qty');
                    })
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('MVR')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cash' => 'Cash on Delivery',
                        'bank_transfer' => 'Bank Transfer',
                        'card' => 'Credit/Debit Card',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'cash' => 'primary',
                        'bank_transfer' => 'success',
                        'card' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),

                ImageColumn::make('payment_slip_path')
                    ->label('Payment Slip')
                    ->disk('public')
                    ->size(40)
                    ->defaultImageUrl(null)
                    ->visible(fn($record) => $record && $record->payment_slip_path)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->url(fn($record) => $record && $record->payment_slip_path ? asset('storage/' . $record->payment_slip_path) : null),
            ])
            ->filters([
                SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Cash on Delivery',
                        'bank_transfer' => 'Bank Transfer',
                        'card' => 'Credit/Debit Card',
                    ]),

                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_processing')
                        ->label('Mark as Processing')
                        ->icon('heroicon-m-arrow-path')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'processing']);
                            });
                        })
                        ->requiresConfirmation(),

                    BulkAction::make('mark_shipped')
                        ->label('Mark as Shipped')
                        ->icon('heroicon-m-truck')
                        ->color('info')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'shipped']);
                            });
                        })
                        ->requiresConfirmation(),

                    BulkAction::make('mark_delivered')
                        ->label('Mark as Delivered')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'delivered']);
                            });
                        })
                        ->requiresConfirmation(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
