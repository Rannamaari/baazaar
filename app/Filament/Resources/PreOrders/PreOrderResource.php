<?php

namespace App\Filament\Resources\PreOrders;

use App\Filament\Resources\PreOrders\Pages\CreatePreOrder;
use App\Filament\Resources\PreOrders\Pages\EditPreOrder;
use App\Filament\Resources\PreOrders\Pages\ListPreOrders;
use App\Filament\Resources\PreOrders\Schemas\PreOrderForm;
use App\Filament\Resources\PreOrders\Tables\PreOrdersTable;
use App\Models\PreOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PreOrderResource extends Resource
{
    protected static ?string $model = PreOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PreOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreOrders::route('/'),
            'create' => CreatePreOrder::route('/create'),
            'edit' => EditPreOrder::route('/{record}/edit'),
        ];
    }
}
