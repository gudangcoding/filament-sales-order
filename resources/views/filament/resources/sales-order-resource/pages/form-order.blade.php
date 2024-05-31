<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}
        {{-- <x-filament-panels::form.actions :actions="['save']" /> --}}
        <button type="button" wire:click="save"
            class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
            Save
        </button>
    </x-filament-panels::form>
</x-filament-panels::page>
