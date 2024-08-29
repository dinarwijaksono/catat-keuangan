<div @class([
    'bg-green-100 shadow-sm border border-green-400 text-green-700 px-4 py-3 rounded-sm mb-4 mx-4',
    'hidden' => $isHidden,
])>
    <p>{{ $message }}</p>

    <div class="flex justify-end">
        <button wire:click="doHideAlert"
            class="bg-blue-500 hover:bg-blue-700 text-white text-[13px] rounded-sm py-1 px-2">Tutup</button>
    </div>
</div>
