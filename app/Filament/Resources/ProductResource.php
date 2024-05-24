<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
// use App\Filament\Resources\ProductResource\RelationManagers\ProductVariantRelationManager;
use App\Filament\Resources\ProductResource\Widgets\ProductOverview;
use App\Models\Category;
use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Team;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\RawJs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;


    // protected static ?string $tenantOwnershipRelationshipName = 'products';
    protected static ?string $tenantRelationshipName = 'produk';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $recordTitleAttribute = 'name'; //untuk global search
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master Data';
    public static function getNavigationBadge(): ?string
    {
        return Product::count();
    }

    protected function getModalWidth(): string
    {
        return 'screen'; // Atau 'sm', 'md', 'lg', 'xl','screen' sesuai kebutuhan Anda
    }


    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $teamId = Filament::getTenant()->id; //$user->currentTeam->id
        return $form
            ->schema([

                Section::make('Product Form')
                    ->label('Cari Produk')
                    ->columns(4)
                    ->schema([
                        FileUpload::make('gambar_produk')
                            ->disk('public')
                            ->directory('product')
                            ->image(),
                        // ->required(),
                        // SpatieMediaLibraryFileUpload::make('gambar_produk')->image(),

                        TextInput::make('kode_produk')
                            ->default('P-' . str_pad(Product::max('id') + 1, 4, '0', STR_PAD_LEFT))
                            ->label('Kode Produk')
                            ->required(),
                        TextInput::make('nama_produk_cn')
                            ->label('Nama Produk (Cn)'),
                        TextInput::make('nama_produk')
                            ->label('Nama Produk (ID)')
                            ->required(),
                        Select::make('category_id')
                            ->label('Kategori Produk')
                            ->placeholder('Pilih')
                            ->searchable()
                            ->options(Category::all()->pluck('name', 'id'))
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Kategori')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionAction(fn ($action) => $action->modalWidth('sm'))
                            ->createOptionUsing(function ($data) {
                                $existingCategory = Category::where('name', $data['name'])->first();

                                if ($existingCategory) {
                                    return "Kategori sudah ada";
                                } else {
                                    $newCategory = Category::create($data);
                                    return $newCategory->id;
                                }
                            }),
                        Textarea::make('deskripsi')->label('Deskripsi'),
                        Toggle::make('aktif')
                            ->label('Aktif'),
                        Hidden::make('team_id')->default($teamId),
                        Hidden::make('user_id')->default($user->id)
                    ]),



                Tabs::make('Tab')

                    ->tabs([
                        Tabs\Tab::make('Harga')
                            ->model(Product::class)

                            ->schema([
                                TextInput::make('ctn')
                                    ->label('Carton')
                                    ->Default(1),
                                TextInput::make('price_ctn')
                                    ->label('Harga/Ctn')
                                    ->Default(1),
                                TextInput::make('box')
                                    ->label('Box')
                                    ->Default(1),
                                TextInput::make('price_box')
                                    ->label('Harga/box')
                                    ->Default(1),
                                TextInput::make('lusin')
                                    ->label('Lusin')
                                    ->Default(1),
                                TextInput::make('price_lsn')
                                    ->label('Harga/Lusin')
                                    ->Default(1),
                                TextInput::make('pack')
                                    ->label('Pack')
                                    ->Default(1),
                                TextInput::make('price_pack')
                                    ->label('Harga/Pack')
                                    ->Default(1),
                                TextInput::make('pcs')
                                    ->label('Pcs')
                                    ->Default(1),
                                TextInput::make('price_pcs')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->label('Harga/pcs')
                                    ->Default(1),


                            ])->columns(10),

                        Tabs\Tab::make('Inventori')
                            ->model(Product::class) // target input data

                            ->schema([
                                // Field form terkait inventori
                                TextInput::make('stok')->label('Stok'),
                                TextInput::make('minimum_stok')->label('Stok Minimum'),
                                // ... field form lainnya
                            ]),

                        Tabs\Tab::make('Penjualan')
                            ->model(Product::class) // target input data

                            ->schema([
                                // Field form terkait penjualan
                                TextInput::make('jumlah_terjual')->label('Jumlah Terjual'),
                                TextInput::make('pendapatan_penjualan')->label('Pendapatan Penjualan'),
                                // ... field form lainnya
                            ]),

                        Tabs\Tab::make('Pembelian')
                            ->model(Product::class) // target input data

                            ->schema([
                                // Field form terkait pembelian
                                TextInput::make('jumlah_dibeli')->label('Jumlah Dibeli'),
                                TextInput::make('biaya_pembelian')->label('Biaya Pembelian'),
                                // ... field form lainnya
                            ]),

                        Tabs\Tab::make('Bea Cukai')
                            ->model(Product::class) // target input data

                            ->schema([
                                // Field form terkait bea cukai
                                TextInput::make('bea_masuk')->label('Bea Masuk'),
                                TextInput::make('bea_keluar')->label('Bea Keluar'),
                                // ... field form lainnya
                            ]),
                    ])
                    ->columnSpanFull()




            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $userId = $user->id;
        return $table
            ->modifyQueryUsing(function (Builder $query) use ($userId) {
                // filter jika bukan super_admin
                if (!auth()->user()->hasAnyRole(['admin', 'super_admin'])) {
                    $query->where('user_id', $userId);
                }
            })
            ->columns([
                ImageColumn::make('gambar_produk')
                    ->label('Gambar Produk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_produk')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),


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
            // ProductVariantRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductOverview::class,
        ];
    }
}
