<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
// use Illuminate\Routing\Redirector;
use Livewire\Features\SupportRedirects\Redirector;

class EditSalesOrder extends EditRecord
{
    protected static string $resource = SalesOrderResource::class;

    #[On('refreshForm')]
    public function refreshForm(): void
    {
        parent::refreshFormData(array_keys($this->record->toArray()));
        // dd($this->record->toArray());
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),

        ];
    }
    public function redirectToIndex()
    {
        return redirect()->route('sales-orders.index');
    }

    protected function getFooterActions(): array
    {
        return [
            Summarizer::make('koli')->label('Total Koli'),
        ];
    }

    public function getTitle(): string|Htmlable
    {

        return "Form Detail Order ";
    }




    protected function afterSave()
    {
        $salesOrderId = $this->record->id;
        $slug = Filament::getTenant()->slug;

        // return redirect()->route('pdf.invoice', [
        //     'tenant' => $slug,
        //     'id' => $salesOrderId
        // ]);


        // Filament::notify(
        //     'success',
        //     'Pesanan berhasil diubah',
        //     'Pesanan berhasil diubah, silahkan tekan tombol dibawah untuk melihat invoice',
        //     fn (): Redirector => redirect()->route('pdf.invoice', [
        //         'tenant' => $slug,
        //         'id' => $salesOrderId
        //     ])
        // )->options([
        //     'position' => 'top-end',
        //     'timer' => 10000,
        //     'toast' => true,
        //     'showConfirmButton' => true,
        //     'onClose' => new RawJs('window.location.href = "' . route('sales-orders.index') . '"'),
        // ]);



        $message = 'Pesanan berhasil diubah';
        echo "<script>
        Swal.fire({
            title: 'Success',
            text: '" . $message . "',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lihat Invoice'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '" . route('pdf.invoice', [
            'tenant' => $slug,
            'id' => $salesOrderId
        ]) . "';
            } else {
                window.location.href = '" . route('pdf.invoice', [
            'tenant' => $slug,
            'id' => $salesOrderId
        ]) . "';
            }
        })
        </script>";
    }
}
