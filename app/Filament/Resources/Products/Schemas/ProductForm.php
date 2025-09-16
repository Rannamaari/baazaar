<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $state) => $set('slug', \Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($set) {
                        $set('subcategory_id', null);
                        $set('brand_id', null);
                    }),
                Select::make('subcategory_id')
                    ->relationship(
                        'subcategory',
                        'name',
                        fn($query, $get) => $query->where('category_id', $get('category_id'))
                    )
                    ->nullable()
                    ->live()
                    ->visible(fn($get) => $get('category_id')),
                Select::make('brand_id')
                    ->relationship(
                        'brand',
                        'name',
                        fn($query, $get) => $query->whereHas('categories', function ($q) use ($get) {
                            $q->where('categories.id', $get('category_id'));
                        })
                    )
                    ->nullable()
                    ->visible(fn($get) => $get('category_id')),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->suffix('MVR'),
                TextInput::make('compare_at_price')
                    ->numeric()
                    ->nullable()
                    ->step(0.01)
                    ->suffix('MVR'),
                TextInput::make('stock')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true),
                RichEditor::make('description')
                    ->columnSpanFull(),
                Repeater::make('images')
                    ->relationship()
                    ->schema([
                        FileUpload::make('path')
                            ->directory('product-images')
                            ->disk('public')
                            ->image()
                            ->required(),
                        TextInput::make('position')
                            ->numeric()
                            ->default(1),
                    ])
                    ->orderable('position')
                    ->columnSpanFull(),
            ]);
    }
}
