<?php

namespace App\Filament\Resources\PreOrders\Pages;

use App\Filament\Resources\PreOrders\PreOrderResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPreOrders extends ListRecords
{
    protected static string $resource = PreOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_customer_form')
                ->label('Customer Form')
                ->icon('heroicon-o-plus-circle')
                ->url(route('pre-orders.create'))
                ->openUrlInNewTab()
                ->color('gray'),
            Action::make('view_all_customer_pages')
                ->label('Customer Pages')
                ->icon('heroicon-o-eye')
                ->url(route('pre-orders.index'))
                ->openUrlInNewTab()
                ->color('gray'),
            CreateAction::make(),
        ];
    }
}
