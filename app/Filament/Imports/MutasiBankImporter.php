<?php

namespace App\Filament\Imports;

use App\Models\MutasiBank;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class MutasiBankImporter extends Importer
{
    protected static ?string $model = MutasiBank::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('team')
                ->relationship(),
            ImportColumn::make('user')
                ->relationship(),
            ImportColumn::make('tanggal')
                ->rules(['date']),
            ImportColumn::make('keterangan')
                ->rules(['max:255']),
            ImportColumn::make('cabang')
                ->rules(['max:255']),
            ImportColumn::make('jumlah')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('type')
                ->rules(['max:3']),
            ImportColumn::make('saldo')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?MutasiBank
    {
        // return MutasiBank::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new MutasiBank();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your mutasi bank import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
