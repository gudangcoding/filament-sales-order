<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submit">
        {{ $this->form }}
        {{-- {{ $this->formtotal }} --}}
        <div>
            <x-filament::button type="submit" size="sm">
                Simpan
            </x-filament::button>
        </div>
    </x-filament-panels::form>


    {{-- <x-filament::table :records="$salesDetails">
        <x-filament::table.tr>
            <x-filament::table.th>ID</x-filament::table.th>
            <x-filament::table.th>Nama Produk</x-filament::table.th>
            <x-filament::table.th>Harga</x-filament::table.th>
            <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
        </x-filament::table.tr>
        @foreach ($salesDetails as $salesDetail)
            <x-filament::table.tr>
                <x-filament::table.td>{{ $salesDetail->id }}</x-filament::table.td>
                <x-filament::table.td>{{ $salesDetail->nama_produk }}</x-filament::table.td>
                <x-filament::table.td>{{ $salesDetail->harga }}</x-filament::table.td>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            </x-filament::table.tr>
        @endforeach
    </x-filament::table> --}}
</x-filament-panels::page>
