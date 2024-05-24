{{-- resources/views/filament/components/table-footer.blade.php --}}
<div class="p-4 bg-gray-100">
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <label for="total_harga" class="block text-sm font-medium text-gray-700">Total Harga</label>
                <input type="number" id="total_harga" wire:model="total_harga"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="diskon" class="block text-sm font-medium text-gray-700">Diskon</label>
                <input type="number" id="diskon" wire:model="diskon"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="ongkir" class="block text-sm font-medium text-gray-700">Ongkir</label>
                <input type="number" id="ongkir" wire:model="ongkir"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit
            </button>
        </div>
    </form>
</div>
