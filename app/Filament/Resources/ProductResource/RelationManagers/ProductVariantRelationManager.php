<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;

class ProductVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'ProductVariant';


    public function form(Form $form): Form
    {

        return $form
            ->schema([
                FileUpload::make('gambar')
                    ->directory('product'),

                Select::make('satuan')
                    ->label('Satuan')
                    ->options([
                        'Ctn' => 'Carton',
                        'Box' => 'Box',
                        'Card' => 'Card',
                        'Pcs' => 'Piece',
                    ])
                    ->required(),

                TextInput::make('harga')
                    ->label('Harga')
                    ->required(),
                TextInput::make('ukuran_kemasan')
                    ->label('Ukuran Kemasan')
                    ->helperText('PanjangxLebarxTinggi'),
                // ->required(),
                TextInput::make('isi')
                    ->label('Isi')
                    ->required(),
                TextInput::make('stok')
                    ->label('Stok')
                    ->required(),
                // Placeholder::make('amounts')
                //     ->label('Total Belanja')
                //     ->content(function ($get) {
                //         $sum = 0;
                //         foreach ($get('order_details') as $product) {
                //             $sum = $sum + ($product['harga'] * $product['qty']);
                //         }
                //         return $sum;
                //     }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('satuan'),
                ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('harga'),
                Tables\Columns\TextColumn::make('isi'),
                Tables\Columns\TextColumn::make('stok'),
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