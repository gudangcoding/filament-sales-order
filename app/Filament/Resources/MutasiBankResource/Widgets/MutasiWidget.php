<?php

namespace App\Filament\Resources\MutasibankResource\Widgets;

use App\Models\MutasiBank;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MutasiWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $saldo_akhir = MutasiBank::where('saldo', '!=', 0)->latest()->first()->saldo ?? 0;
        return [
            Stat::make('Saldo Terakhir', number_format($saldo_akhir))
                ->description('Saldo Terakhir')
                ->descriptionIcon('heroicon-o-cube'),
            Stat::make('Jumlah Transaksi', MutasiBank::all()->count())
                ->description('Jumlah Transaksi')
                ->descriptionIcon('heroicon-o-cube'),
        ];
    }
}
