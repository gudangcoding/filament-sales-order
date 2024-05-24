<?php

namespace App\Filament\Resources\CustomerClassResource\Pages;

use App\Filament\Resources\CustomerClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerClass extends EditRecord
{
    protected static string $resource = CustomerClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
