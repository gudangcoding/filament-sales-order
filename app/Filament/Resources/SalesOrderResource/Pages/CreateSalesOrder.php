<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\SalesOrderResource\RelationManagers\SalesDetailRelationManager;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\CustomerClass;
use App\Models\SalesOrder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class CreateSalesOrder extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;

    protected function getFormSchema(): array
    {
        $user = Auth::user();
        $userId = $user->id;
        return [
            Hidden::make('user_id')
                ->default($userId),
            TextInput::make('so_no')
                ->label('No.SO')
                ->afterStateHydrated(function ($set, $get) {
                    $salesOrderId = $get('id');
                    if ($salesOrderId) {
                        $salesOrder = SalesOrder::find($salesOrderId);
                        $salesOrder->so_no = 'SO-' .  date('ymd') . "-" . str_pad($salesOrderId, 4, '0', STR_PAD_LEFT);
                        $salesOrder->save();
                    }
                }),
            Select::make('customer_id')
                ->label('Nama Pelanggan')
                ->placeholder('Pilih')
                ->searchable()
                ->options(Customer::all()->pluck('nama_customer', 'id')->toArray())
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $customer = Customer::where('id', $state)->first();
                    if ($customer) {
                        $customerClass = CustomerClass::where('id', $customer->customer_class_id)->pluck('name')->first();
                        $customerCategory = CustomerCategory::where('id', $customer->customer_category_id)->pluck('name')->first();
                        $set('customer_class_id', $customerClass);
                        $set('customer_category_id', $customerCategory);
                        $set('catatan', $customer->catatan);
                    } else {
                        $set('customer_class_id', null);
                        $set('customer_category_id', null);
                        $set('catatan', null);
                    }
                })
                ->relationship('customer', 'nama_customer')
                ->createOptionForm(fn (Form $form) => CustomerResource::form($form) ?? [])
                ->editOptionForm(fn (Form $form) => CustomerResource::form($form) ?? [])
                ->createOptionAction(fn ($action) => $action->modalWidth(MaxWidth::FiveExtraLarge)),
            TextInput::make('customer_class_id')
                ->reactive()
                ->readOnly()
                ->label('Class'),
            TextInput::make('customer_category_id')
                ->reactive()
                ->readOnly()
                ->label('Kategori'),
            DatePicker::make('tanggal')
                ->default(now())
                ->native(false)
                ->displayFormat('d/m/Y'),
            Textarea::make('catatan')
                ->label('Catatan Tentang Customer')
                ->reactive(),
        ];
    }

    protected function getSecondaryFormSchema(): array
    {
        return [
            TextInput::make('total')
                ->label('Total')
                ->reactive(),
            TextInput::make('ongkir')
                ->label('Ongkir')
                ->reactive(),
            TextInput::make('diskon')
                ->label('Diskon')
                ->reactive(),
            TextInput::make('grand_total')
                ->label('Grand Total')
                ->reactive(),
        ];
    }

    protected function getContent()
    {
        return view('filament.resources.sales-order-resource.pages.form-order', [
            'form' => $this->form->getForm(),
            'secondaryForm' => $this->makeForm()->schema($this->getSecondaryFormSchema())->model($this->record)->statePath('secondaryFormData'),
            'record' => $this->record,
            'relationManager' => $this->relationManager,
        ])->render();
    }
}