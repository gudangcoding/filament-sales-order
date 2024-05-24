<?php

namespace App\Filament\Resources\ProvinsiResource\Pages;

use App\Filament\Imports\ProvinsiImporter;
use App\Filament\Resources\ProvinsiResource;
use App\Imports\ImportProvinsi;
use App\Imports\ProvinsiImport;
use App\Models\Provinsi;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Filament\Actions\ImportAction;
use Filament\Facades\Filament;
use Konnco\FilamentImport\Actions\ImportField;

class ListProvinsis extends ListRecords
{
    protected static string $resource = ProvinsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),


            Action::make("importmutasi")
                ->label('Impor Excel')
                ->form(
                    [
                        FileUpload::make('attachment')
                            ->disk('local') // Menggunakan disk lokal
                            ->directory('provinsi') // Menentukan folder tujuan
                            ->storeFiles(false) // Tidak menyimpan file dalam bentuk path
                            ->visibility('public') // Menentukan visibilitas file
                    ]
                )
                ->action(function (array $data) {
                    try {
                        // Ambil file dari direktori penyimpanan lokal
                        $file = $data['attachment'];

                        // Import file Excel menggunakan Laravel Excel
                        Excel::import(new ProvinsiImport, $file);

                        // Kirim notifikasi jika import berhasil
                        Notification::make()
                            ->title('Import Mutasi successfully')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        // Tangani kesalahan jika terjadi
                        Notification::make()
                            ->title('Import failed: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })



        ];
    }
}
