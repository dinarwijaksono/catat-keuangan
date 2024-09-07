<div @class([
    'bg-red-100 shadow-sm border border-red-400 text-red-700 px-4 py-3 rounded-sm mb-4 mx-4',
    'hidden' => $isHidden,
])>
    <p>{{ $message }}</p>

    <div class="flex justify-end">
        <button wire:click="doHideAlert"
            class="bg-red-500 hover:bg-red-700 text-white text-[13px] rounded-sm py-1 px-2">Tutup</button>
    </div>
</div>
