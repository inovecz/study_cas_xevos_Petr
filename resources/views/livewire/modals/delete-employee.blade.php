<div class="flex flex-col border border-red-500 rounded-b-lg">
    <div class="w-full bg-red-500 text-white px-4 py-2">
        <div class="text-xl"><strong>{{ $employee->getFullname(true) }}</strong></div>
    </div>
    <div class="w-full p-4 border border-b-gray-400">
        <div class="text-md">Opravdu chcete odstranit tohoto zaměstnance?</div>
    </div>
    <div class="w-full px-4 py-2 bg-red-500/10 flex justify-end space-x-4">
        <button wire:loading.remove wire:target="confirm" wire:click="$emit('closeModal')" class="btn btn-link">Zrušit</button>
        <button wire:loading wire:target="confirm" class="btn btn-danger" disabled>Provádím<i class="fa-solid fa-spinner fa-spin-pulse ml-2"></i></button>
        <button wire:loading.remove wire:target="confirm" wire:click="confirm" class="btn btn-danger">Odstranit</button>
    </div>
</div>
