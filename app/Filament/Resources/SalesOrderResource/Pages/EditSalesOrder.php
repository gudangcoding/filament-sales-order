<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Filament\Resources\SalesOrderResource;
use App\Models\SalesOrder;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;

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
        Notification::make()
            ->success()
            ->title('Ingin Print Data Ini?')
            ->body('Lanjutkan')
            ->persistent()
            ->actions([
                Action::make('salesOrder')
                    ->button()
                    ->url(route('pdf.invoice', [
                        'tenant' => $slug,
                        'id' => $salesOrderId
                    ]), shouldOpenInNewTab: true),
            ])
            // ->toDatabase()
            ->send();

        $this->halt();
    }
}
