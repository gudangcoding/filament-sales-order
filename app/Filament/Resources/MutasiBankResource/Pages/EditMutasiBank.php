<?php

namespace App\Filament\Resources\MutasiBankResource\Pages;

use App\Filament\Resources\MutasiBankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMutasiBank extends EditRecord
{
    protected static string $resource = MutasiBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
