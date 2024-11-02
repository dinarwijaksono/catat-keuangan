<section @class([
    'fixed top-0 right-0 left-0 bottom-0 bg-gray-300/75 z-50',
    'hidden' => $isHidden,
])>
    <div class="flex justify-center mt-[100px]">
        <div class="p-4 bg-white rounded-lg w-5/12 shadow-lg">
            <h1 class="font-semibold text-center mb-3">Buat Kategori</h1>

            <div class="mb-4">
                <label for="date" class="mb-1">Nama</label>
                <input type="text" wire:model="categoryName" id="date" autofocus
                    class="w-full border border-gray-300 p-1 rounded-md px-2" placeholder="Keterangan">
                @error('categoryName')
                    <p class="text-red-500 italic text-[14px]">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date" class="mb-1">Type</label>
                <div class="flex gap-2 p-2">
                    <div class="basis-6/12">
                        <button wire:click="doSetType('income')" @class([
                            'rounded-lg px-2 py-1 text-white w-full',
                            'bg-gray-500' => $type != 'income',
                            'bg-green-500' => $type == 'income',
                        ])>Pemasukan</button>
                    </div>

                    <div class="basis-6/12">
                        <button wire:click="doSetType('spending')" @class([
                            'rounded-lg px-2 py-1 text-white w-full',
                            'bg-gray-500' => $type != 'spending',
                            'bg-green-500' => $type == 'spending',
                        ])>Pengeluaran</button>
                    </div>
                </div>

                @error('type')
                    <p class="text-red-500 italic text-[14px]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 justify-end">
                <div class="basis-2/12">
                    <button wire:click="doHideBox"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Batal</button>
                </div>

                <div class="basis-2/12">
                    <button type="button" wire:click="doCreateCategory"
                        class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Simpan</button>
                </div>
            </div>

        </div>
    </div>
</section>
