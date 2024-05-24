<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use App\Filament\Resources\UserResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class SalesOrderActivities extends ListActivities
{
    protected static string $resource = SalesOrderResource::class;
}
