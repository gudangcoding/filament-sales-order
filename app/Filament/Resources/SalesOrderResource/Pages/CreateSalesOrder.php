<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\SalesOrderResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSalesOrder extends CreateRecord
{
    protected static string $resource = SalesOrderResource::class;
}
