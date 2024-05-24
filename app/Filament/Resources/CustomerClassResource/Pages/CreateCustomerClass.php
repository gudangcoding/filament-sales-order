<?php

namespace App\Filament\Resources\CustomerClassResource\Pages;

use App\Filament\Resources\CustomerClassResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerClass extends CreateRecord
{
    protected static string $resource = CustomerClassResource::class;
}
