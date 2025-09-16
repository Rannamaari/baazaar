<?php

namespace App\Filament\Resources\PreOrders\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PreOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pre-Order Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending Review',
                                        'reviewing' => 'Under Review',
                                        'sourcing' => 'Being Sourced',
                                        'sourced' => 'Item Sourced',
                                        'cancelled' => 'Cancelled',
                                        'completed' => 'Completed',
                                    ])
                                    ->required()
                                    ->default('pending'),
                            ]),
                            
                        Grid::make(2)
                            ->schema([
                                TextInput::make('product_name')
                                    ->required()
                                    ->maxLength(255),
                                    
                                TextInput::make('brand')
                                    ->maxLength(255),
                            ]),
                            
                        TextInput::make('product_url')
                            ->label('Product URL')
                            ->url()
                            ->required()
                            ->maxLength(500),
                            
                        Textarea::make('additional_details')
                            ->rows(3)
                            ->maxLength(1000),
                    ]),
                    
                Section::make('Admin Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('estimated_price')
                                    ->numeric()
                                    ->prefix('MVR')
                                    ->step(0.01),
                                    
                                TextInput::make('final_price')
                                    ->numeric()
                                    ->prefix('MVR')
                                    ->step(0.01),
                            ]),
                            
                        Textarea::make('admin_notes')
                            ->rows(3)
                            ->maxLength(1000),
                    ])
                    ->collapsible(),
            ]);
    }
}
