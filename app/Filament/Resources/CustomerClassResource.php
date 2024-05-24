<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerClassResource\Pages;
use App\Filament\Resources\CustomerClassResource\RelationManagers;
use App\Models\CustomerClass;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerClassResource extends Resource
{
    protected static ?string $model = CustomerClass::class;
    protected static ?string $navigationGroup = "Settings";
    // protected static ?string $navigationParentItem = "Customer";
    protected static ?string $tenantRelationshipName = 'custumerClass';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        TextInput::make('name'),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
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
            'index' => Pages\ListCustomerClasses::route('/'),
            'create' => Pages\CreateCustomerClass::route('/create'),
            'edit' => Pages\EditCustomerClass::route('/{record}/edit'),
        ];
    }
}
