<?php

namespace App\Filament\Resources\SalesOrderResource\RelationManagers;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\SalesDetail;
use App\Models\SalesOrder;
use Filament\Actions\Action;

use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Filament\Tables\Actions\EditAction;
use Livewire\Component;

class SalesDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'SalesDetail';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('satuan')
                    ->placeholder('Pilih')
                    ->options([
                        'ctn' => 'Carton',
                        'box' => 'Box',
                        'bag' => 'Bag',
                        'card' => 'Card',
                        'lusin' => 'Lusin',
                        'pack' => 'Pack',
                        'pcs' => 'Pcs'
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Get $get) {
                        $ketemu = Product::find($get('product_id'));

                        if ($ketemu) {
                            $harga = match ($state) {
                                'ctn' => $ketemu->price_ctn,
                                'box' => $ketemu->price_box,
                                'bag' => $ketemu->price_bag,
                                'card' => $ketemu->price_card,
                                'lusin' => $ketemu->price_lsn,
                                'pack' => $ketemu->price_pack,
                                'pcs' => $ketemu->price_pcs,
                                default => 0,
                            };
                            // dd($harga);
                            $subtotal = $get('qty') * $harga;
                            $set('harga', number_format($subtotal, 2, '.', ''));
                            $set('subtotal', number_format($subtotal, 2, '.', ''));
                        }
                    })
                    ->columnSpan(1),

                Select::make('product_id')
                    ->placeholder('Pilih')
                    ->options(function () {
                        // Ambil semua id produk yang sudah ada di 'sales_detail'
                        $existingProductIds = SalesDetail::whereNotNull('id')->pluck('product_id')->toArray();
                        // Kueri produk yang tidak termasuk dalam daftar id yang sudah ada
                        $products = Product::query()
                            ->whereNotIn('id', $existingProductIds)
                            ->pluck('nama_produk', 'id');
                        return $products;
                    })
                    // Sisipkan logika lain seperti biasa
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set, Get $get) {
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
                    })
                    ->relationship('product', 'nama_produk')
                    ->createOptionForm(fn (Form $form) => ProductResource::form($form) ?? [])
                    ->editOptionForm(fn (Form $form) => ProductResource::form($form) ?? [])
                    ->distinct()
                    // ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->columnSpan(['sm' => 2])
                    ->searchable(),
                TextInput::make('qty')
                    ->label('Quantity')
                    ->default(1)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set, Get $get) {
                        $harga = $get('harga');
                        $subtotal = $harga * $state;
                        $set('subtotal', $subtotal);
                    })
                    ->required()
                    ->columnSpan(1),
                TextInput::make('harga')
                    // ->mask(RawJs::make('$money($input)'))
                    // ->stripCharacters(',')
                    ->columnSpan(1)
                    ->label('Unit Price')
                    ->required()
                    ->readOnly(),
                TextInput::make('subtotal')
                    // ->mask(RawJs::make('$money($input)'))
                    // ->stripCharacters(',')
                    ->numeric()
                    ->columnSpan(1)
                    ->label('Subtotal')
                    ->default(function ($state, Forms\Set $set, Get $get) {
                        return $get('qty') * $get('harga');
                    })
                    ->readOnly(),

            ])->columns(5);
    }
    public function table(Table $table): Table
    {
        return $table

            ->defaultGroup('koli')
            ->groupRecordsTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Group records'),
            )
            ->recordTitleAttribute('product_id')
            ->columns([

                TextColumn::make('product.nama_produk')
                    ->label('Nama Produk'),
                ImageColumn::make('gambar_produk')
                    ->label('Gambar'),
                TextColumn::make('harga')
                    ->label('Harga'),
                TextColumn::make('satuan')
                    ->label('Satuan'),
                TextColumn::make('qty')
                    ->label('Qty'),
                TextColumn::make('subtotal')
                    ->money('IDR', locale: 'id')
                    ->label('SubTotal'),
                TextColumn::make('kolian')
                    // ->summarize(Count::make())
                    // ->summarize([
                    //     Tables\Columns\Summarizers\Count::make(),
                    // ])
                    ->label('Koli')
                    ->default(1),
            ])

            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (Component $livewire, $action) {
                        $salesOrderId = $action->getRecord()->sales_order_id;
                        $salesOrder = SalesOrder::find($salesOrderId);
                        $sum = $salesOrder->order_details->sum('subtotal');
                        $salesOrder->subtotal = $sum;
                        $salesOrder->diskon = (float) str_replace(',', '', $salesOrder->diskon);
                        $salesOrder->ongkir = (float) str_replace(',', '', $salesOrder->ongkir);
                        $salesOrder->grand_total = $sum - $salesOrder->diskon + $salesOrder->ongkir;
                        $salesOrder->save();
                        return $livewire->dispatch('refreshForm');
                    }),
            ])

            ->actions([
                Tables\Actions\EditAction::make()

                    ->after(function (Component $livewire, $action) {
                        $salesOrderId = $action->getRecord()->sales_order_id;
                        $salesOrder = SalesOrder::find($salesOrderId);
                        $sum = $salesOrder->order_details->sum('subtotal');
                        $salesOrder->subtotal = $sum;
                        $salesOrder->diskon = (float) str_replace(',', '', $salesOrder->diskon);
                        $salesOrder->ongkir = (float) str_replace(',', '', $salesOrder->ongkir);
                        $salesOrder->grand_total = $sum - $salesOrder->diskon + $salesOrder->ongkir;
                        $salesOrder->save();
                        return $livewire->dispatch('refreshForm');
                    }),


                Tables\Actions\DeleteAction::make()
                    ->after(function (Component $livewire, $action) {
                        $salesOrderId = $action->getRecord()->sales_order_id;
                        $salesOrder = SalesOrder::find($salesOrderId);
                        $sum = $salesOrder->order_details->sum('subtotal');
                        $salesOrder->subtotal = $sum;
                        $salesOrder->diskon = (float) str_replace(',', '', $salesOrder->diskon);
                        $salesOrder->ongkir = (float) str_replace(',', '', $salesOrder->ongkir);
                        $salesOrder->grand_total = $sum - $salesOrder->diskon + $salesOrder->ongkir;
                        $salesOrder->save();
                        return $livewire->dispatch('refreshForm');
                    }),
            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('Satukan Koli')
                        ->icon('heroicon-m-check')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('koli')
                                ->label('Koli')
                                ->options(function () {
                                    $koliExisting = SalesDetail::whereNotNull('koli')->pluck('koli')->toArray();
                                    $lastKoli = !empty($koliExisting) ? max($koliExisting) : 0;
                                    $nextKoli = $lastKoli ? $lastKoli + 1 : 1;

                                    $options = [
                                        null => 'Keluarkan',
                                    ];

                                    foreach ($koliExisting as $koli) {
                                        $options[$koli] = $koli;
                                    }

                                    $options[$nextKoli] = $nextKoli;

                                    return $options;
                                })
                                ->default(null)

                                ->distinct(),
                            TextInput::make('jumlah_koli')
                                ->label('Jumlah Koli'),
                            // Select::make('koli')
                            //     ->label('Koli')
                            //     ->options(function (SalesDetail $record) {
                            //         $salesOrderId = $record->getKey();
                            //         // $salesOrderId = $record->sales_order_id;
                            //         if (!$salesOrderId) {
                            //             return [
                            //                 null => 'Keluarkan',
                            //             ];
                            //         }

                            //         $koliOptions = SalesDetail::where('sales_order_id', $salesOrderId)
                            //             ->select('koli')
                            //             ->distinct()
                            //             ->pluck('koli')
                            //             ->toArray();

                            //         $options = [
                            //             null => 'Keluarkan',
                            //         ];

                            //         foreach ($koliOptions as $koli) {
                            //             $options[$koli] = $koli;
                            //         }

                            //         $lastKoli = SalesDetail::where('sales_order_id', $salesOrderId)->max('koli');
                            //         $nextKoli = $lastKoli ? $lastKoli + 1 : 1;
                            //         $options[$nextKoli] = $nextKoli;

                            //         return $options;
                            //     })
                            //     ->default(null)
                            //     ->distinct(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(function ($record) use ($data) {

                                SalesDetail::where('id', $record->id)->update([
                                    'koli' => $data['koli'],
                                    'jumlah_koli' => $data['jumlah_koli']
                                ]);
                            });
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),

            ]);
    }

    protected function updateSalesOrderTotals($salesOrderId)
    {

        $salesOrder = SalesOrder::find($salesOrderId);

        if ($salesOrder) {
            $subtotal = $salesOrder->salesDetails->sum('subtotal');
            $diskon = (float) str_replace(',', '', $salesOrder->diskon);
            $ongkir = (float) str_replace(',', '', $salesOrder->ongkir);
            $grandTotal = $subtotal - $diskon + $ongkir;

            $salesOrder->subtotal = $subtotal;
            $salesOrder->grand_total = $grandTotal;
            $salesOrder->save();
        }
    }
}
