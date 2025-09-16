<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('MVR')
                            ->required(),

                        TextInput::make('discount_total')
                            ->label('Discount Total')
                            ->numeric()
                            ->prefix('MVR')
                            ->default(0),

                        TextInput::make('tax_total')
                            ->label('Tax Total')
                            ->numeric()
                            ->prefix('MVR')
                            ->default(0),

                        TextInput::make('shipping_total')
                            ->label('Shipping Total')
                            ->numeric()
                            ->prefix('MVR')
                            ->default(0),

                        TextInput::make('grand_total')
                            ->label('Grand Total')
                            ->numeric()
                            ->prefix('MVR')
                            ->required(),

                        TextInput::make('currency')
                            ->default('MVR')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Payment Information')
                    ->schema([
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash on Delivery',
                                'bank_transfer' => 'Bank Transfer',
                                'card' => 'Credit/Debit Card',
                            ])
                            ->required(),

                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'verified' => 'Verified',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),

                        FileUpload::make('payment_slip_path')
                            ->label('Payment Slip')
                            ->disk('public')
                            ->directory('payment-slips')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize(2048)
                            ->visible(fn ($get, $record) => $get('payment_method') === 'bank_transfer' || ($record && $record->payment_slip_path))
                            ->downloadable()
                            ->openable()
                            ->previewable(),

                        DateTimePicker::make('payment_verified_at')
                            ->label('Payment Verified At')
                            ->visible(fn ($get) => $get('payment_status') === 'verified'),

                        TextInput::make('payment_ref')
                            ->label('Payment Reference'),
                    ])
                    ->columns(2),

                Section::make('Delivery Information')
                    ->schema([
                        Textarea::make('delivery_address')
                            ->label('Delivery Address')
                            ->rows(3)
                            ->required(),

                        TextInput::make('delivery_phone')
                            ->label('Delivery Phone')
                            ->tel()
                            ->required(),
                    ])
                    ->columns(1),

                Section::make('Admin Notes')
                    ->schema([
                        Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->placeholder('Add any admin notes about this order...'),
                    ])
                    ->columns(1),
            ]);
    }
}
