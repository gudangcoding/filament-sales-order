<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
// use App\Filament\Resources\ProductResource\RelationManagers\ProductVariantRelationManager;
use App\Filament\Resources\ProductResource\Widgets\ProductOverview;
use App\Models\Category;
use App\Models\Product;
use App\Models\Satuan;
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
use Filament\Forms\Components\Repeater;
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
                            ->image()
                            ->rules(['image', 'max:2048'])
                            ->disk('public')
                            ->visibility('public')
                            ->directory('product'),

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
                        Tabs\Tab::make('Satuan')
                            ->schema([
                                Repeater::make('satuan')
                                    ->label('MultiLevelSatuan')
                                    ->relationship('satuan')
                                    ->schema([
                                        Select::make('parent_id')
                                            ->label('Satuan Utama')
                                            ->options(Satuan::all()->pluck('name', 'id'))
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Satuan')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionAction(fn ($action) => $action->modalWidth('sm'))
                                            ->createOptionUsing(function ($data) {
                                                $existingSatuan = Satuan::where('name', $data['name'])->first();

                                                if ($existingSatuan) {
                                                    return "Satuan sudah ada";
                                                } else {
                                                    $newSatuan = Satuan::create($data);
                                                    return $newSatuan->id;
                                                }
                                            })
                                            ->columnSpan(1),
                                        TextInput::make('name')
                                            ->columnSpan(1)
                                            ->label('Name'),
                                        TextInput::make('qty')
                                            ->columnSpan(1)
                                            ->label('Qty'),
                                        TextInput::make('harga')
                                            ->columnSpan(1)
                                            ->label('Harga'),
                                    ])
                                    ->columns(4)
                                    ->addActionLabel('Tambah Satuan')

                            ]),

                        Tabs\Tab::make('Inventori')
                            ->model(Product::class)
                            ->schema([
                                TextInput::make('stok')->label('Stok'),
                                TextInput::make('minimum_stok')->label('Stok Minimum'),
                            ]),

                        Tabs\Tab::make('Penjualan')
                            ->model(Product::class)

                            ->schema([
                                TextInput::make('jumlah_terjual')->label('Jumlah Terjual'),
                                TextInput::make('pendapatan_penjualan')->label('Pendapatan Penjualan'),

                            ]),

                        Tabs\Tab::make('Pembelian')
                            ->model(Product::class)

                            ->schema([
                                TextInput::make('jumlah_dibeli')->label('Jumlah Dibeli'),
                                TextInput::make('biaya_pembelian')->label('Biaya Pembelian'),
                            ]),

                        Tabs\Tab::make('Bea Cukai')
                            ->model(Product::class)

                            ->schema([
                                TextInput::make('bea_masuk')->label('Bea Masuk'),
                                TextInput::make('bea_keluar')->label('Bea Keluar'),
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
