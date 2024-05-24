<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Tambah Tenant';
    }

    public function form(Form $form): Form
    {
        // $user = Auth::user();
        // $userId = $user->id;
        return $form
            ->schema([
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn (Set $set, ?string $state) =>
                        $set('slug', str::slug($state))
                    ),
                TextInput::make('slug'),
                // Hidden::make('user_id')->default($userId),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}
