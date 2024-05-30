<?php

namespace App\Filament\Resources\SalesOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengirimanRelationManager extends RelationManager
{
    protected static string $relationship = 'Pengiriman';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('jenis_kirim')
                    ->reactive()
                    ->options([
                        'Ekspedisi' => 'Ekspedisi',
                        'Titip' => 'Titip',
                        'Kirim' => 'Kirim',
                        'Ambil' => 'Ambil Sendiri',
                    ]),
                TextInput::make('nama_ekspedisi'),
                TextInput::make('via'),
                TextInput::make('tujuan'),
                TextInput::make('nama_toko'),
                TextInput::make('alamat'),
                TextInput::make('plat_mobil'),
                TextInput::make('sopir'),
                TextInput::make('no_hp'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sales_order_id')
            ->columns([
                Tables\Columns\TextColumn::make('sales_order_id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
