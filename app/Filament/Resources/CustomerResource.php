<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Contacts;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\CustomerClass;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use App\Models\Alamat;
use Illuminate\Support\Facades\DB;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        $userId = Auth::user()->id;
        $teamId = Filament::getTenant()->id;

        return $form
            ->schema([
                Section::make('Customer Form')
                    ->columns(4)
                    ->schema([
                        TextInput::make('kode_customer')
                            ->label('Kode Customer')
                            ->default('C-' . str_pad(Customer::max('id') + 1, 4, '0', STR_PAD_LEFT)),
                        TextInput::make('nama_customer')
                            ->label('Nama Customer'),
                        TextInput::make('daerah_customer')
                            ->label('Daerah Customer'),
                        Select::make('customer_class_id')
                            ->placeholder('cash/tempo')
                            ->label('Kelas Pelanggan')
                            ->searchable()
                            ->options(CustomerClass::all()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Kelas Pelanggan')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionAction(fn ($action) => $action->modalWidth('sm'))
                            ->createOptionUsing(function ($data) {
                                $class = CustomerClass::create($data);
                                return $class->id;
                            }),
                        Select::make('customer_category_id')
                            ->label('Kategori Pelanggan')
                            ->placeholder('toko/online')
                            ->searchable()
                            ->options(CustomerCategory::all()->pluck('name', 'id'))
                            ->createOptionAction(fn ($action) => $action->modalWidth('sm'))
                            //memanggil form tambah
                            ->createOptionForm(fn (Form $form) => CustomerCategoryResource::form($form) ?? [])
                            // //memanggil form edit harus ada relasi
                            // ->relationship('kategori_customer')
                            // // ->editOptionForm(fn (Form $form, $get) => CustomerCategoryResource::form($form) ?? [])
                            // ->editOptionForm(fn (Form $form, $get) => CustomerClassResource::form($form)
                            //     ->model(CustomerClass::find($get('customer_id'))) ?? [])
                            //aksi untuk form
                            ->createOptionUsing(function ($data) {
                                $cus_cat = CustomerCategory::create($data);
                                return $cus_cat->id;
                            }),
                        TextInput::make('sisa_limit_hutang')
                            ->label('Sisa Limit Hutang')
                            ->numeric()
                            ->default(0),
                        TextInput::make('total_hutang')
                            ->label('Total Hutang')
                            ->numeric()
                            ->default(0),
                        TextInput::make('hutang_dlm_tempo')
                            ->label('Hutang Dalam Tempo')
                            ->numeric()
                            ->default(0),
                        TextInput::make('hutang_lewat_tempo')
                            ->label('Hutang Lewat Tempo')
                            ->numeric()
                            ->default(0),
                        TextInput::make('limit_nota')
                            ->label('Limit Nota')
                            ->numeric()
                            ->default(0),
                        TextInput::make('limit_hutang')
                            ->numeric()
                            ->label('Limit Hutang')
                            ->default(0),
                        TextInput::make('jenis_badan_usaha')
                            ->label('Jenis Badan Usaha')
                            ->placeholder('PT/CV/UD Dll'),
                        Hidden::make('team_id')->default($teamId),
                        Hidden::make('user_id')->default($userId)
                    ]),
                Tabs::make('Tab')
                    ->tabs([
                        Tabs\Tab::make('Info')
                            ->schema([
                                Repeater::make('contacts')
                                    ->relationship('contacts')
                                    ->schema([
                                        Select::make('sebutan')
                                            ->label('Sebutan')
                                            ->options([
                                                'pa' => 'Pa',
                                                'pak' => 'Pak',
                                                'bu' => 'Bu',
                                                'ibu' => 'Ibu',
                                                'ko' => 'Ko',
                                                'ci' => 'Ci',
                                                'bang' => 'Bang',
                                                'mba' => 'Mba',
                                                'h' => 'H',
                                                'hj' => 'Hj',
                                                'haji' => 'Haji',
                                                'hajah' => 'Hajah',
                                                'tk' => 'Tk'
                                            ]),
                                        TextInput::make('no_hp')->label('No. HP'),
                                        TextInput::make('nama')->label('Nama'),
                                        TextInput::make('hubungan')->label('Hubungan'),
                                        TextInput::make('msg_app')->placeholder('WA/IG/LINE etc'),
                                        Hidden::make('team_id')->default($teamId),
                                        Hidden::make('user_id')->default($userId)
                                    ])
                                    ->columns(5)
                                    ->label('Contacts')
                                    ->addActionLabel('Tambah Kontak'),
                            ]),
                        Tabs\Tab::make('Alamat')
                            ->schema([
                                Repeater::make('alamats')
                                    ->relationship('alamat')
                                    ->schema([
                                        TextInput::make('label_alamat')->label('Label Alamat')->default('Pusat'),
                                        TextInput::make('negara')->label('Negara')->default('INDONESIA'),
                                        TextInput::make('provinsi')->label('Provinsi')->default('JAKARTA'),
                                        TextInput::make('kabupaten_kota')->label('Kabupaten/Kota')->default('JAKARTA BARAT'),
                                        TextInput::make('kecamatan')->label('Kecamatan')->default('DAAN MOGOT'),
                                        TextInput::make('kelurahan_desa')->label('Kelurahan/Desa')->default('KAPUK'),
                                        TextInput::make('rt_rw')->label('RT/RW')->default('001/01'),
                                        Textarea::make('alamat')->label('Alamat')->default('Jl. PETERNAKAN II, Gg IKAN ASIN'),
                                        TextInput::make('no_unit')->label('No/Unit')->default('No.16'),
                                        TextInput::make('tambahan')->label('Tambahan')->default('KOMPLEK PERGUDANGAN NAGATA, GUDANG S3'),
                                        TextInput::make('kode_pos')->label('Kode Pos')->default('11420'),
                                        Hidden::make('team_id')->default($teamId),
                                        Hidden::make('user_id')->default($userId)
                                    ])->columns(4)


                            ]),

                        Tabs\Tab::make('Catatan')
                            ->icon('heroicon-o-bell')
                            ->schema([
                                Textarea::make('catatan')
                                    ->label('Perhatian')
                                    ->placeholder("CONTOH: SUKA PESAN DIKIT2 MULTI SO\nCONTOH: SUKA BILANG KIRIMNYA KURANG BARANG"),
                            ]),
                        Tabs\Tab::make('Pembayaran')
                            ->schema([
                                Repeater::make('banks')
                                    ->relationship('banks')
                                    ->schema([
                                        TextInput::make('nama_bank')->label('Nama Bank'),
                                        TextInput::make('atas_nama')->label('Atas Nama'),
                                        TextInput::make('alias')->label('Nama Alias'),
                                        TextInput::make('no_rek')->label('No Rekening'),
                                        Hidden::make('team_id')->default($teamId),
                                        Hidden::make('user_id')->default($userId)
                                    ])
                                    ->columns(4)
                                    ->label('Info Rekening Bank')
                                    ->addActionLabel('Tambah Bank'),
                            ]),
                        Tabs\Tab::make('Pembelian')
                            ->schema([
                                DatePicker::make('tgl_beli')->label('Tgl Beli')->displayFormat('d/m/Y')
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_customer')->label('Nama Customer')->searchable(),
                Tables\Columns\TextColumn::make('jenis_badan_usaha')->label('Tipe Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('daerah_customer')->label('Daerah Customer')->searchable(),
                Tables\Columns\TextColumn::make('kelas.name')->label('Kelas')->searchable(),
                Tables\Columns\TextColumn::make('kategori_customer.name')->label('Kategori')->searchable(),
            ])
            ->filters([
                // Add filters if necessary
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        if (is_null($data)) {
            throw new \Exception("Record creation failed");
        }
        $userId = Auth::user()->id;
        $teamId = Filament::getTenant()->id;

        if (isset($data['contacts'])) {
            foreach ($data['contacts'] as &$contact) {
                $contact['team_id'] = $teamId;
                $contact['user_id'] = $userId;
            }
        }

        if (isset($data['banks'])) {
            foreach ($data['banks'] as &$bank) {
                $bank['team_id'] = $teamId;
                $bank['user_id'] = $userId;
            }
        }

        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        if (is_null($data)) {
            throw new \Exception("Record creation failed");
        }
        $userId = Auth::user()->id;
        $teamId = Filament::getTenant()->id;

        if (isset($data['contacts'])) {
            foreach ($data['contacts'] as &$contact) {
                $contact['team_id'] = $teamId;
                $contact['user_id'] = $userId;
            }
        }

        if (isset($data['banks'])) {
            foreach ($data['banks'] as &$bank) {
                $bank['team_id'] = $teamId;
                $bank['user_id'] = $userId;
            }
        }

        return $data;
    }

    public static function afterCreate($record, array $data)
    {
        if (is_null($record)) {
            throw new \Exception("Record creation failed");
        }
        if (isset($data['contacts'])) {
            foreach ($data['contacts'] as $contactData) {
                $record->contacts()->create($contactData);
            }
        }

        if (isset($data['banks'])) {
            foreach ($data['banks'] as $bankData) {
                $record->banks()->create($bankData);
            }
        }
    }

    public static function afterSave($record, array $data)
    {
        if (is_null($record)) {
            throw new \Exception("Record creation failed");
        }
        $record->contacts()->delete();
        $record->banks()->delete();

        if (isset($data['contacts'])) {
            foreach ($data['contacts'] as $contactData) {
                $record->contacts()->create($contactData);
            }
        }

        if (isset($data['banks'])) {
            foreach ($data['banks'] as $bankData) {
                $record->banks()->create($bankData);
            }
        }
    }
}
