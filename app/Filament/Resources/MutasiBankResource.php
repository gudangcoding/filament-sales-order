<?php

namespace App\Filament\Resources;

use App\Filament\Imports\MutasiBankImporter;
use App\Filament\Resources\MutasiBankResource\Pages;
use App\Filament\Resources\MutasiBankResource\RelationManagers;
use App\Filament\Resources\MutasibankResource\Widgets\MutasiWidget;
use App\Imports\ImportMutasi;
use App\Models\MutasiBank;
use Doctrine\DBAL\Schema\Column;
use Filament\Actions\ImportAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class MutasiBankResource extends Resource
{
    protected static ?string $model = MutasiBank::class;
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Mutasi Bank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal'),
                TextColumn::make('nama'),
                // TextColumn::make('keterangan'),
                TextColumn::make('cabang'),
                TextColumn::make('jumlah'),
                TextColumn::make('type'),
                TextColumn::make('saldo'),
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
            'index' => Pages\ListMutasiBanks::route('/'),
            'create' => Pages\CreateMutasiBank::route('/create'),
            'edit' => Pages\EditMutasiBank::route('/{record}/edit'),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    public static function getWidgets(): array
    {
        return [
            MutasiWidget::class,
        ];
    }
}
