<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\SalesOrderResource\RelationManagers\SalesDetailRelationManager;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;

class CreateSalesOrderCustom extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;

    protected static string $view = 'filament.resources.sales-order-resource.pages.create-sales-order-custom';
    protected function getFormSchema(): array
    {
        return [
            Section::make('Header')
                ->schema([
                    TextInput::make('so_no')->required()->label('Sales Order No'),
                    DatePicker::make('tanggal')->required()->label('Date'),
                    Select::make('customer_id')->relationship('customer', 'name')->required()->label('Customer'),
                    TextInput::make('team_id')->required()->label('Team ID'),
                ]),
            Section::make('Detail Produk')
                ->schema([
                    Repeater::make('order_details')
                        ->relationship('order_details')
                        ->schema([
                            Select::make('product_id')->relationship('product', 'nama_produk')->required()->label('Product'),
                            TextInput::make('satuan')->required()->label('Unit'),
                            TextInput::make('harga')->numeric()->required()->label('Price'),
                            TextInput::make('qty')->numeric()->required()->label('Quantity'),
                            TextInput::make('subtotal')->numeric()->required()->label('Subtotal'),
                            TextInput::make('koli')->required()->label('Koli'),
                            TextInput::make('jumlah_koli')->numeric()->required()->label('Jumlah Koli'),
                        ])
                ]),
            Section::make('Total')
                ->schema([
                    TextInput::make('subtotal')->numeric()->required()->label('Subtotal'),
                    TextInput::make('diskon')->numeric()->required()->label('Discount'),
                    TextInput::make('ongkir')->numeric()->required()->label('Shipping Cost'),
                    TextInput::make('grand_total')->numeric()->required()->label('Grand Total'),
                ]),
            Section::make('Pengiriman')
                ->schema([
                    Select::make('pengiriman_id')->relationship('pengiriman', 'nama_ekspedisi')->required()->label('Shipping'),
                    TextInput::make('plat_mobil')->label('Vehicle Plate'),
                    TextInput::make('sopir')->label('Driver'),
                    TextInput::make('no_hp')->label('Phone Number'),
                    Textarea::make('alamat')->label('Address'),
                    TextInput::make('nama_toko')->label('Store Name'),
                ])
        ];
    }

    protected function getContent(): string
    {
        return view('filament.resources.sales-order-resource.pages.create-sales-order', [
            'form' => $this->form,
            'relationManager' => SalesDetailRelationManager::class,
        ])->render();
    }
}
