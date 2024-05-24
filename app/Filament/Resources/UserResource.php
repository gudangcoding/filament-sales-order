<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $tenantRelationshipName = 'members';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $recordTitleAttribute = 'name'; //untuk global search
    public static function getNavigationGroup(): ?string
    {
        return 'Hak Akses';
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // protected static ?string $navigationGroup = 'Settings';
    public static function getNavigationBadge(): ?string
    {
        return User::count();
    }
    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $userId = $user->id;
        return $form
            ->schema([
                Section::make('Form User')

                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email'),
                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),


                                Select::make('roles')->multiple()->relationship('roles', 'name')
                                // Forms\Components\CheckboxList::make('roles')
                                //     ->relationship('roles', 'name')
                                //     ->searchable()
                            ])->columns(2)
                    ]),
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
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('roles.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Log Pengguna')->url(fn ($record) => UserResource::getUrl('aktifitas', ['record' => $record]))
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'aktifitas' => Pages\ListUserActivities::route('/{record}/aktifitas'),
        ];
    }
}
