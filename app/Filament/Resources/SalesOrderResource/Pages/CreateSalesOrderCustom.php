<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\SalesOrderResource\RelationManagers\SalesDetailRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;

class CreateSalesOrderCustom extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;

    protected static string $view = 'filament.resources.sales-order-resource.pages.create-sales-order-custom';
    protected function getFormSchema(): array
    {
        return array_merge(
            SalesOrderResource::form($this->form)->getSchema(),
            [
                // Tambahkan field tambahan yang diinginkan
                TextInput::make('total')
                    ->label('Total')
                    ->required(),
                TextInput::make('ongkir')
                    ->label('Ongkir')
                    ->required(),
                TextInput::make('diskon')
                    ->label('Diskon')
                    ->required(),
                TextInput::make('grand_total')
                    ->label('Grand Total')
                    ->required(),
            ]
        );
    }

    protected function getContent(): string
    {
        return view('filament.resources.sales-order-resource.pages.create-sales-order', [
            'form' => $this->form,
            'relationManager' => SalesDetailRelationManager::class,
        ])->render();
    }
}
