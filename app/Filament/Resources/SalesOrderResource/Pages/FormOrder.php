<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\SalesDetail;
use App\Models\Pengiriman;
use App\Models\Product;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FormOrder extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SalesOrderResource::class;
    protected static string $view = 'filament.resources.sales-order-resource.pages.form-order';

    public ?SalesOrder $salesOrder;

    public function mount(): void
    {
        $pathInfo = request()->url();
        $segments = explode('/', $pathInfo);
        $salesOrderId = $segments[6] ?? null;

        if ($salesOrderId) {
            $this->salesOrder = SalesOrder::with('order_details')->find($salesOrderId);
            // echo json_encode($this->salesOrder);
        } else {
            $this->salesOrder = new SalesOrder();
        }

        $this->form->fill($this->salesOrder->toArray());
        // dd($this->salesOrder->toArray());
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Header Sales Order')
                ->columns([
                    'sm' => 6,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([
                    Card::make('Data Pelanggan')
                        ->columnSpan([
                            'md' => 4,
                        ])->schema([
                            TextInput::make('so_no')
                                ->label('Sales Order No')
                                ->default($this->salesOrder->so_no ?? ''),
                            Select::make('customer_id')
                                ->options(Customer::all()->pluck('nama_customer', 'id'))
                                ->searchable()
                                ->label('Customer')
                                ->default($this->salesOrder->customer_id ?? ''),
                            TextInput::make('class')
                                ->label('Class')
                                ->default($this->salesOrder->class ?? ''),
                            TextInput::make('customer_category')
                                ->label('Kategori')
                                ->default($this->salesOrder->customer_category ?? ''),
                            DatePicker::make('tanggal')
                                ->required()
                                ->native(false)
                                ->displayFormat(function (): string {
                                    return 'd/m/Y';
                                })
                                ->label('Date')
                                ->default($this->salesOrder->tanggal ?? ''),
                        ])->columns(2),
                    Card::make('Data Pengiriman')
                        ->columnSpan([
                            'md' => 2,
                        ])
                        ->schema([
                            Select::make('pengiriman_id')
                                ->label('Pengiriman')
                                ->options([
                                    'Ekspedisi' => 'Ekspedisi',
                                    'Kirim' => 'Kirim',
                                    'Titip' => 'Titip',
                                    'Ambil Sendiri' => 'Ambil Sendiri',
                                ])
                                ->default($this->salesOrder->pengiriman_id ?? ''),
                            TextInput::make('plat_mobil')->label('Vehicle Plate')
                                ->default($this->salesOrder->plat_mobil ?? ''),
                            TextInput::make('sopir')->label('Driver')
                                ->default($this->salesOrder->sopir ?? ''),
                            TextInput::make('no_hp')->label('Phone Number')
                                ->default($this->salesOrder->no_hp ?? ''),
                            Textarea::make('alamat')->label('Address')
                                ->default($this->salesOrder->alamat ?? ''),
                            TextInput::make('nama_toko')->label('Store Name')
                                ->default($this->salesOrder->nama_toko ?? ''),
                        ]),
                ]),
            Section::make('Detail Produk')
                ->schema([
                    Repeater::make('order_details')
                        // ->relationship('order_details')
                        ->schema([
                            Select::make('product_id')
                                ->options(Product::all()->pluck('nama_produk', 'id'))
                                ->searchable()
                                ->afterStateUpdated(function ($state, $set, Get $get) {
                                    $ketemu = Product::find($state);
                                    if ($ketemu) {
                                        $satuan = $get('satuan');
                                        $harga = match ($satuan) {
                                            'ctn' => $ketemu->price_ctn,
                                            'box' => $ketemu->price_box,
                                            'bag' => $ketemu->price_bag,
                                            'card' => $ketemu->price_card,
                                            'lusin' => $ketemu->price_lsn,
                                            'pack' => $ketemu->price_pack,
                                            'pcs' => $ketemu->price_pcs,
                                            default => 0,
                                        };
                                        $subtotal = $get('qty') * $harga;
                                        $set('harga', $harga);
                                        $set('subtotal', $subtotal);
                                    } else {
                                        $set('harga', 0);
                                        $set('subtotal', 0);
                                    }
                                }),
                            TextInput::make('satuan')->required()->label('Satuan'),
                            TextInput::make('harga')->numeric()->required()->label('Price'),
                            TextInput::make('qty')->numeric()->required()->label('Quantity'),
                            TextInput::make('subtotal')->numeric()->required()->label('Subtotal'),
                        ])
                        ->addActionLabel('Tambah Produk')
                        ->columns(5),
                ]),
            Section::make('Total')
                ->columns([
                    'sm' => 6,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([
                    Card::make()
                        ->columnSpan([
                            'md' => 4,
                        ]),
                    Card::make('Total Belanja')
                        ->columnSpan([
                            'md' => 2,
                        ])
                        ->schema([
                            TextInput::make('subtotal')->numeric()->required()->label('Subtotal')
                                ->default($this->salesOrder->subtotal ?? 0),
                            TextInput::make('diskon')->numeric()->required()->label('Discount')
                                ->default($this->salesOrder->diskon ?? 0),
                            TextInput::make('ongkir')->numeric()->required()->label('Shipping Cost')
                                ->default($this->salesOrder->ongkir ?? 0),
                            TextInput::make('grand_total')->numeric()->required()->label('Grand Total')
                                ->default($this->salesOrder->grand_total ?? 0),
                        ])
                ])->columns(3),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            $this->salesOrder->fill($data);
            $this->salesOrder->save();

            $this->sendSuccessNotification();
        } catch (Exception $e) {
            Notification::make()->danger()->title('Error')->body($e->getMessage())->send();
        }
    }

    private function sendSuccessNotification(): void
    {
        Notification::make()->success()->title('Success')->send();
    }
}
