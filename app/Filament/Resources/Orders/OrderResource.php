<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\RelationManagers\OrderItemsRelationManager;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $pluralModelLabel = 'Orders';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'orderItems.product']);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getActions(): array
    {
        return [
            Action::make('approve_payment')
                ->label('Approve Payment')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Order $record) => $record->isBankTransferOrder() && $record->isPaymentPending())
                ->form([
                    Textarea::make('admin_notes')
                        ->label('Admin Notes')
                        ->placeholder('Add any notes about this payment approval...')
                        ->rows(3),
                ])
                ->action(function (Order $record, array $data) {
                    $record->update([
                        'payment_status' => 'verified',
                        'payment_verified_at' => now(),
                        'admin_notes' => $data['admin_notes'] ?? null,
                    ]);

                    Notification::make()
                        ->title('Payment Approved')
                        ->body('The payment has been successfully approved.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation(),

            Action::make('reject_payment')
                ->label('Reject Payment')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Order $record) => $record->isBankTransferOrder() && $record->isPaymentPending())
                ->form([
                    Textarea::make('admin_notes')
                        ->label('Rejection Reason')
                        ->placeholder('Please provide a reason for rejecting this payment...')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (Order $record, array $data) {
                    $record->update([
                        'payment_status' => 'rejected',
                        'admin_notes' => $data['admin_notes'],
                    ]);

                    Notification::make()
                        ->title('Payment Rejected')
                        ->body('The payment has been rejected.')
                        ->warning()
                        ->send();
                })
                ->requiresConfirmation(),
        ];
    }
}
