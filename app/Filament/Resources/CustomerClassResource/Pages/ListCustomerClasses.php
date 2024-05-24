<?php

namespace App\Filament\Resources\CustomerClassResource\Pages;

use App\Filament\Resources\CustomerClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerClasses extends ListRecords
{
    protected static string $resource = CustomerClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
