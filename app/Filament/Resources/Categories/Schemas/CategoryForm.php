<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', \Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('icon')
                    ->label('Icon (Emoji or Lucide icon name)')
                    ->placeholder('e.g., 🛍️ or shopping-bag')
                    ->helperText('Enter an emoji or Lucide icon name (without the "lucide-" prefix)'),
                Toggle::make('is_featured')
                    ->label('Featured Category')
                    ->helperText('Maximum 3 categories can be featured')
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if (! $state) {
                            $set('featured_rank', null);
                        }
                    }),
                Select::make('featured_rank')
                    ->label('Featured Rank')
                    ->options([
                        1 => 'Rank 1 (Highest)',
                        2 => 'Rank 2',
                        3 => 'Rank 3 (Lowest)',
                    ])
                    ->visible(fn ($get) => $get('is_featured'))
                    ->required(fn ($get) => $get('is_featured'))
                    ->validationMessages([
                        'unique' => 'This rank is already taken by another featured category.',
                    ])
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if ($value && ! Category::isFeaturedRankAvailable($value, request()->route('record'))) {
                                    $fail('This rank is already taken by another featured category.');
                                }
                            };
                        },
                    ]),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
