<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesOrderResource\Pages;
use App\Filament\Resources\SalesOrderResource\RelationManagers;
use App\Filament\Resources\SalesOrderResource\RelationManagers\SalesDetailRelationManager;
use App\Models\Customer;
use App\Models\SalesOrder;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\SalesOrderResource\Pages\FormOrder;
use App\Filament\Resources\SalesOrderResource\Pages\CreateSalesOrderCustom;
use App\Filament\Resources\SalesOrderResource\RelationManagers\PengirimanRelationManager;
use App\Models\CustomerCategory;
use App\Models\CustomerClass;
use App\Models\SalesDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Doctrine\DBAL\Schema\Schema;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\Reactive;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;
    protected static ?string $ownershipRelationship = "salesOrders";
    protected static ?string $tenantOwnershipRelationshipName = "team";
    protected static ?string $navigationGroup = "Marketing";
    protected static ?string $label = 'Sales Order';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        $user = Auth::user();
        $userId = $user->id;
        return $form
            ->schema([
                Section::make()
                    ->columns([
                        'sm' => 6,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        Card::make('Data Pelanggan')
                            ->columnSpan([
                                'md' => 4,
                            ])
                            ->schema([
                                Hidden::make('user_id')
                                    ->default($userId),
                                TextInput::make('so_no')
                                    ->label('No.SO')
                                    // ->default('SO-' .  date('ymd') . "-" . str_pad(SalesOrder::max('id') + 1, 4, '0', STR_PAD_LEFT))
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

                                    // ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        // Mencari customer berdasarkan ID yang dipilih
                                        $customer = Customer::where('id', $state)->get()->first();
                                        $catatan = $customer->catatan ?? null;


                                        if ($customer) {
                                            // dd($customer);
                                            // Mendapatkan class dan chanel dari customer
                                            $customerClass = CustomerClass::where('id', $customer->customer_class_id)->pluck('name')->first();
                                            $customerCategory = CustomerCategory::where('id', $customer->customer_category_id)->pluck('name')->first();

                                            // Mengupdate nilai customer_class_id dan customer_category_id
                                            $set('customer_class_id', $customerClass ? $customerClass : null);
                                            $set('customer_category_id', $customerCategory ? $customerCategory : null);
                                            $set('catatan', $catatan ? $catatan : null);
                                        } else {
                                            // Jika customer tidak ditemukan, set nilai ke null
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
                                    ->afterStateHydrated(function ($set, $get) {
                                        $customerId = $get('customer_id');
                                        if ($customerId) {
                                            $catatan = CustomerClass::where('id', $customerId)->pluck('name')->first();
                                            $set('customer_class_id', $catatan);
                                        }
                                    })

                                    ->label('Class'),

                                TextInput::make('customer_category_id')
                                    ->reactive()
                                    ->readOnly()
                                    ->afterStateHydrated(function ($set, $get) {
                                        $customerId = $get('customer_id');
                                        if ($customerId) {
                                            $catatan = CustomerCategory::where('id', $customerId)->pluck('name')->first();
                                            $set('customer_category_id', $catatan);
                                        }
                                    })
                                    ->label('Kategori'),

                                DatePicker::make('tanggal')
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),

                                TextArea::make('catatan')
                                    ->label('Catatan Tentang Customer')
                                    ->reactive()
                                    ->afterStateHydrated(function ($set, $get) {
                                        $customerId = $get('customer_id');
                                        if ($customerId) {
                                            $catatan = Customer::where('id', $customerId)->pluck('catatan')->first();
                                            $set('catatan', $catatan);
                                        }
                                    }),
                            ])->columns(2),

                        Card::make('Total Bayar')
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->schema([
                                TextInput::make('subtotal')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->readOnly()
                                    ->label('Total Belanja')
                                    ->reactive()
                                    ->afterStateHydrated(function ($set, $get) {
                                        $salesOrderId = $get('id');
                                        if ($salesOrderId) {
                                            $sum = SalesDetail::where('sales_order_id', $salesOrderId)->sum('subtotal');
                                            $formattedSum = $sum ? $sum : 0;
                                            $set('subtotal', $formattedSum);

                                            // Hitung grand total saat subtotal diinisialisasi
                                            $diskon = (float) str_replace(',', '', $get('diskon'));
                                            $ongkir = (float) str_replace(',', '', $get('ongkir'));
                                            $grandTotal = $sum - $diskon + $ongkir;
                                            $set('grand_total', number_format($grandTotal, 2, '.', ','));
                                        }
                                    }),

                                TextInput::make('diskon')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $diskon = is_numeric(str_replace(',', '', $state)) ? str_replace(',', '', $state) : 0;
                                        $ongkir = is_numeric(str_replace(',', '', $get('ongkir'))) ? str_replace(',', '', $get('ongkir')) : 0;

                                        $totalBelanja = SalesDetail::where('sales_order_id', $get('id'))->sum('subtotal');

                                        if ($totalBelanja === null) {
                                            $totalBelanja = 0;
                                        }

                                        $grandTotal = $totalBelanja - $diskon + $ongkir;
                                        $set('grand_total', number_format($grandTotal, 2, '.', ','));
                                    })
                                    ->label('Diskon'),

                                TextInput::make('ongkir')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $diskon = is_numeric(str_replace(',', '', $get('diskon'))) ? str_replace(',', '', $get('diskon')) : 0;
                                        $ongkir = is_numeric(str_replace(',', '', $state)) ? str_replace(',', '', $state) : 0;

                                        $totalBelanja = SalesDetail::where('sales_order_id', $get('id'))->sum('subtotal') ?? 0;

                                        if ($totalBelanja === null) {
                                            $totalBelanja = 0;
                                        }

                                        $grandTotal = $totalBelanja - $diskon + $ongkir;
                                        $set('grand_total', number_format($grandTotal, 2, '.', ',') ?? 0);
                                    })
                                    ->label('Ongkir'),

                                TextInput::make('grand_total')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->reactive()
                                    ->label('Total')
                                    ->readOnly()
                                    ->afterStateHydrated(function ($set, $get) {
                                        $diskon = (float) str_replace(',', '', $get('diskon'));
                                        $ongkir = (float) str_replace(',', '', $get('ongkir'));
                                        $totalBelanja = SalesDetail::where('sales_order_id', $get('id'))->sum('subtotal');
                                        $totalBelanja = $totalBelanja ? $totalBelanja : 0; // Pastikan total belanja tidak null
                                        $grandTotal = $totalBelanja - $diskon + $ongkir;
                                        // $set('grand_total', $grandTotal);
                                        $set('grand_total', number_format($grandTotal, 2, '.', ',') ?? 0);
                                    }),
                            ])

                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable(),
                TextColumn::make('so_no')
                    ->searchable(),
                TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('diskon')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ongkir')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Action::make('edit')
                //     ->url(fn (SalesOrder $record): string => route('pdf.invoice', [
                //         'tenant' => Filament::getTenant()->slug,
                //         'id' => $record->id
                //     ]))
                //     ->openUrlInNewTab(),
                // Tables\Actions\Action::make('Log Order')->url(fn ($record) => SalesOrderResource::getUrl('aktifitas', ['record' => $record]))
                Tables\Actions\Action::make('pdf')
                    ->label('Download SO?')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-circle')
                    ->action(function (Model $record) {
                        $salesOrderId = $record->id;
                        $slug = Filament::getTenant()->slug;
                        return redirect()->route('pdf.invoice', [
                            'tenant' => $slug,
                            'id' => $salesOrderId
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            SalesDetailRelationManager::class,
            PengirimanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesOrders::route('/'),
            'create' => Pages\CreateSalesOrderCustom::route('/create'),
            'edit' => Pages\FormOrder::route('/{record}/edit'),
            'form-order' => Pages\FormOrder::route('/form-order/{record?}'),
            // 'formOrder' => FormOrder::route('/{record}/edit'),
            // 'aktifitas' => Pages\ListSalesOrders::route('/{record}/aktifitas'),
        ];
    }
}
