<?php

namespace App\Filament\Resources\SalesOrderResource\RelationManagers;

use App\Models\SalesOrder;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranRelationManager extends RelationManager
{
    protected static string $relationship = 'Pembayaran';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->native(false)
                    ->displayFormat('d/M/Y')
                    ->nullable(),
                TextInput::make('jumlah_hutang')
                    ->default(fn ($record) => $record->id)
                    ->disabled(),
                TextInput::make('jumlah_bayar')->nullable(),
                TextInput::make('sisa')->nullable(),
                FileUpload::make('bukti_bayar')->nullable(),
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
