<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Customer;
use App\Models\DataAlamat;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SalesOrder;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $tenantRelationshipName = 'invoice';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        $products = Product::get();
        $user = Auth::user();
        $userId = $user->id;
        return $form
            ->schema([

                Section::make('')
                    ->columns([
                        'sm' => 6,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        Card::make('Detail Pelanggan')
                            ->columnSpan([
                                'md' => 4,
                            ])
                            ->schema([
                                Hidden::make('user_id')->default($userId),
                                TextInput::make('order_number')
                                    ->default('INV-' . date('Ymd') . '-' . random_int(100000, 999999))
                                    ->unique()
                                    ->readOnly(),
                                Select::make('customer_id')
                                    ->label('Customer')
                                    ->options(Customer::get()->pluck('name', 'id'))
                                    // ->options(Customer::where('tipe', 'customer')->pluck('name', 'id'))
                                    ->required()

                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required(),
                                        TextInput::make('no_hp')
                                            ->label('Nomor HP')
                                            ->required(),
                                        TextInput::make('alamat')
                                            ->required(),
                                        Select::make('type')
                                            ->options([
                                                'customer' => 'Customer',
                                                'supplier' => 'Supplier',
                                                'other' => 'Other'
                                            ])
                                            ->default('customer')
                                            ->required(),
                                    ]),

                                Select::make('status')->label('Status')->options([
                                    'Baru' => 'Baru',
                                    'Pending' => 'Pending',
                                    'Diproses' => 'Diproses',
                                    'Completed' => 'Completed',
                                ])->required(),
                                Select::make('type_bayar')->label('Tipe Pembayaran')->options([
                                    'Cash Langsung' => 'Cash Langsung',
                                    'Cash Tempo' => 'Cash Tempo',
                                    'Tempo Langsung' => 'Tempo Langsung',
                                    'Cek Customer' => 'Cek Customer',
                                ])->required(),
                            ])
                            ->columns(2),

                        Card::make('Akumulasi Invoice')
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->schema([

                                Placeholder::make('amount')
                                    ->label('Total Invoice')
                                    ->content(function ($get) {
                                        $sum = 0;
                                        foreach ($get('invoice_detail') as $product) {
                                            $sum = $sum + ($product['subtotal']);
                                        }
                                        return $sum;
                                    }),
                                TextInput::make('dp')
                                    ->label('DP')
                                    ->required(),
                                TextInput::make('sisa')
                                    ->label('Sisa')
                                    ->required(),
                                TextInput::make('Termin')
                                    ->label('termin')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(1),
                    ]),


                Card::make('Detail Invoice')
                    ->schema([
                        Repeater::make('invoice_detail')
                            ->relationship()
                            ->schema([
                                Grid::make('')
                                    ->schema([
                                        Select::make('product_id')
                                            ->label('No Order')
                                            ->options(SalesOrder::query()->pluck('id', 'id'))
                                            ->required()
                                            ->live(onBlur: true)

                                            ->distinct()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->columnSpan([
                                                'md' => 2,
                                            ])

                                            ->searchable(),

                                        TextInput::make('qty')
                                            ->label('Total Barang')
                                            ->default(1)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, Forms\Set $set, Get $get) {
                                                $qty = $state;
                                                $harga = $get('harga');
                                                $subtotal = $harga * $qty;
                                                $set('subtotal', $subtotal);
                                            })
                                            ->required()
                                            ->columnSpan(1),
                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->reactive()
                                            ->columnSpan(1)
                                            ->label('Invoice Amount')
                                            ->numeric()
                                            ->default(function ($state, Forms\Set $set, Get $get) {
                                                if ($get('qty') === '' && $get('harga')) {
                                                    $subttotal = $get('qty') * $get('harga');
                                                } else {
                                                    $subttotal = 0;
                                                }

                                                return  number_format($subttotal, 2, '.', '');
                                            })
                                            ->disabled()

                                    ])
                                    ->columns(4)

                            ])
                            ->addActionLabel('Tambah Order'),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}