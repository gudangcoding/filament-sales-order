<?php

namespace App\Filament\Imports;

use App\Models\Provinsi;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\ImportAction;

class ProvinsiImporter extends Importer
{
    protected static ?string $model = Provinsi::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('team')
                ->relationship(),
            ImportColumn::make('user_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Provinsi
    {
        // return Provinsi::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Provinsi();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your provinsi import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
