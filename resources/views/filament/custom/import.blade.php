<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/mutasi-banks' => 'Mutasi Bank',
        '' => 'List',
    ]" />
    <div class="flex justify-between mt-1">
        <div class="text-3xl font-bold">Form Import Mutasi</div>
        <div>
            {{ $data }}
        </div>
    </div>
    <div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form wire:submit="save" class="flex w-full max-w-sm mt-2">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="fileInput">
                    Pilih Berkas
                </label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="fileInput" type="file" wire:model='file'>
            </div>
            {{-- <div class="flex items-center justify-between mt-3">
                <button
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                    type="submit" style="display: block;">
                    Unggah
                </button>
            </div> --}}

            <div class="flex items-center justify-between mt-3">
                <button type="submit" class="bg-blue-500">
                    Unggah
                </button>
            </div>

        </form>
    </div>
</div>
