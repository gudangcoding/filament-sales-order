<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('All Product', Product::all()->count())
                ->description('Semua Produk')
                ->descriptionIcon('heroicon-o-cube'),
            Stat::make('Variant Product', Product::all()->count())
                ->description('Variasi Produk')
                ->descriptionIcon('heroicon-o-cube'),
            Stat::make('Total Stok', Product::sum('stok'))
                ->description('Total Stok Produk')
                ->descriptionIcon('heroicon-o-cube'),
        ];
    }
}