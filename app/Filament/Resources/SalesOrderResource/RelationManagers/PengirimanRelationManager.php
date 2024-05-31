<?php

namespace App\Filament\Resources\SalesOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengirimanRelationManager extends RelationManager
{
    protected static string $relationship = 'pengiriman';

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
                        'Ambil Sendiri' => 'Ambil Sendiri',
                    ])
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('is_ekspedisi', $state === 'Ekspedisi');
                        $set('is_titip', $state === 'Titip');
                        $set('is_kirim', $state === 'Kirim');
                        $set('is_ambil_sendiri', $state === 'Ambil Sendiri');
                    }),

                TextInput::make('nama_ekspedisi')
                    ->visible(fn (Get $get) => $get('is_ekspedisi')),

                TextInput::make('via')
                    ->visible(fn (Get $get) => $get('is_ekspedisi')),

                TextInput::make('tujuan')
                    ->visible(fn (Get $get) => $get('is_ekspedisi')),

                TextInput::make('nama_toko')
                    ->visible(fn (Get $get) => $get('is_titip')),

                TextInput::make('alamat')
                    ->visible(fn (Get $get) => $get('is_titip')),

                TextInput::make('plat_mobil')
                    ->visible(fn (Get $get) => $get('is_kirim')),

                TextInput::make('sopir')
                    ->visible(fn (Get $get) => $get('is_kirim')),

                TextInput::make('no_hp')
                    ->visible(fn (Get $get) => $get('is_kirim') || $get('is_ambil_sendiri')),
                TextInput::make('nama_pengambil')
                    ->visible(fn (Get $get) => $get('is_ambil_sendiri')),
            ]);
    }



    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sales_order_id')
            ->columns([
                TextColumn::make('jenis_kirim')
                    ->label('Jenis'),

                TextColumn::make('via')
                    ->label('Via')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Ekspedisi' ? $record->via : '-';
                    }),

                TextColumn::make('tujuan')
                    ->label('Tujuan')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Ekspedisi' ? $record->tujuan : '-';
                    }),

                TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Titip' ? $record->nama_toko : '-';
                    }),

                TextColumn::make('plat_mobil')
                    ->label('Plat Mobil')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Kirim' ? $record->plat_mobil : '-';
                    }),

                TextColumn::make('sopir')
                    ->label('Sopir')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Kirim' ? $record->sopir : '-';
                    }),

                TextColumn::make('no_hp')
                    ->label('No HP')
                    ->getStateUsing(function ($record) {
                        return $record->jenis_kirim === 'Kirim' || $record->jenis_kirim === 'Ambil Sendiri' ? $record->no_hp : '-';
                    }),
            ])
            ->filters([
                SelectFilter::make('jenis_kirim')
                    ->label('Jenis Kirim')
                    ->options([
                        'Ekspedisi' => 'Ekspedisi',
                        'Titip' => 'Titip',
                        'Kirim' => 'Kirim',
                        'Ambil Sendiri' => 'Ambil Sendiri',
                    ]),
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
