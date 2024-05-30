<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}
        {{-- <x-filament-panels::form.actions :actions="['save']" /> --}}
        <button type="button" wire:click="save" class="filament-button filament-button-primary">
            Save
        </button>
    </x-filament-panels::form>
</x-filament-panels::page>
