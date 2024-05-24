<?php

namespace App\Filament\Resources\MutasiBankResource\Pages;

use App\Filament\Resources\MutasiBankResource;
use App\Filament\Resources\MutasibankResource\Widgets\MutasiWidget;
use App\Imports\ImportMutasi;
use App\Imports\MutasiBankImport;
use App\Models\Customer;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;

class ListMutasiBanks extends ListRecords
{
    protected static string $resource = MutasiBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make("importmutasi")
                ->label('Impor Excel')
                ->form(
                    [
                        FileUpload::make('attachment')
                            ->disk('public') // Specify the disk where the file is stored
                            ->directory('import') // Specify the directory
                        // ->acceptedFileTypes([
                        //     'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        //     'application/vnd.ms-excel',
                        //     'text/csv'
                        // ])
                    ]
                )
                ->action(function (array $data) {
                    $file = public_path('storage/' . $data['attachment']);
                    // // dd($file);
                    // Excel::import(new ImportMutasi, $file);
                    // Notification::make()
                    //     ->title('Import Mutasi successfully')
                    //     ->success()
                    //     ->send();


                    try {

                        // Excel::import(new MutasiBankImport, $file, null, \Maatwebsite\Excel\Excel::XLSX);
                        Excel::import(new ImportMutasi, $file);
                        Notification::make()
                            ->title('Import Mutasi successfully')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import failed: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function getTitle(): string|Htmlable
    {

        return "Mutasi Bank ";
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MutasiWidget::class,
        ];
    }
}
