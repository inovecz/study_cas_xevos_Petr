<div class="flex flex-col border border-blue-500 rounded-b-lg">
    <div class="w-full bg-blue-500 text-white px-4 py-2">
        <div class="text-xl"><strong>Editace zaměstnance</strong></div>
    </div>
    <form wire:submit.prevent="submit">
        <div class="w-full p-4 border border-b-gray-400">
            <div class="flex space-x-4">
                <label class="block mt-2 w-1/2">
                    <span class="text-gray-700 text-lg">Jméno</span>
                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
                    @error('name') <div class="mt-1 text-xs text-red-500">{{ $message }}</div> @enderror
                </label>

                <label class="block mt-2 w-1/2">
                    <span class="text-gray-700 text-lg">Příjmení</span>
                    <input type="text" wire:model="surname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
                    @error('surname') <div class="mt-1 text-xs text-red-500">{{ $message }}</div> @enderror
                </label>
            </div>

            <div class="flex space-x-4">
                <label class="block mt-2 w-1/2">
                    <span class="text-gray-700 text-lg">Datum</span>
                    <input type="date" wire:model="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
                    @error('date') <div class="mt-1 text-xs text-red-500">{{ $message }}</div> @enderror
                </label>

                <div class="block mt-2 w-1/2 relative">
                    <span class="text-gray-700 text-lg">Výplata</span>
                    <div class="relative">
                        <input type="number" wire:model="salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
                        <span class="absolute top-1/2 right-6 transform -translate-x-1/2 -translate-y-1/2 text-gray-700 origin-center">Kč</span>
                        @error('salary') <div class="mt-1 text-xs text-red-500">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full px-4 py-2 bg-blue-500/10 flex justify-end space-x-4">
            <button wire:loading.remove wire:target="submit" wire:click="$emit('closeModal')" class="btn btn-link">Zrušit</button>
            <button wire:loading wire:target="submit" class="btn btn-primary" disabled>Provádím<i class="fa-solid fa-spinner fa-spin-pulse ml-2"></i></button>
            <button wire:loading.remove wire:target="submit" class="btn btn-primary">Uložit</button>
        </div>
    </form>
</div>
