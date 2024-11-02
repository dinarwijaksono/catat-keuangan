<div @class([
    'fixed top-24 right-10 w-[800px] mb-4 shadow-lg shadow-slate-500 bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded-lg',
    'hidden' => $isHidden,
])>
    <div class="mb-4">
        <p>{{ $message }}</p>
    </div>
    <div class="flex justify-end">
        <div class="basis-2/12">
            <button wire:click="doHideAlert"
                class="px-2 py-0 w-full text-[14px] border border-slate-500 text-slate-700 hover:text-white bg-slate-100 hover:bg-slate-700 rounded-lg">Tutup</button>
        </div>
    </div>
</div>
