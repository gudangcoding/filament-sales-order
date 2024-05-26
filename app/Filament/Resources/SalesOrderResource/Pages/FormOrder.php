<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\SalesOrderResource;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\CustomerClass;
use App\Models\SalesDetail;
use App\Models\SalesOrder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class FormOrder extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = SalesOrderResource::class;

    protected static string $view = 'filament.resources.sales-order-resource.pages.form-order';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        $user = Auth::user();
        $userId = $user->id;
        return [

            Card::make('Data Pelanggan')
                ->columnSpan([
                    'md' => 4,
                ])
                ->schema([
                    TextInput::make('Nama'),
                    Select::make('customer')
                        ->relationship('customer', 'nama_customer')
                        ->options(Customer::pluck('nama_customer', 'id'))
                        ->searchable()
                        ->createOptionForm(fn (Form $form) => CustomerResource::form($form) ?? [])
                ])->columns(2),
        ];
    }
    protected function formtotal(): array
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
        $salesDetails = SalesDetail::where('sales_order_id', $this->record->id)->get();
        return view('filament.resources.sales-order-resource.pages.form-order', [
            'form' => $this->form,
            'formtotal' => $this->formtotal,
            // 'secondaryForm' => $this->makeForm()->schema($this->getSecondaryFormSchema())->model($this->record)->statePath('secondaryFormData'),
            'record' => $this->record,
            'relationManager' => $this->relationManager,
            'salesDetails' => $salesDetails,
        ])->render();
    }

    public function save(): void
    {
    }
}