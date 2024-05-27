<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save" type="">
        {{ $this->form }}
       <div>
         {{-- {{ $this->formtotal }} --}}
       </div>
       <div>
         {{-- {{ $this->formtotal }} --}}
       </div>

        <div>
            <x-filament::button type="submit" size="sm">
                Simpan
            </x-filament::button>
        </div>
    </x-filament-panels::form>

</x-filament-panels::page>
