<section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">
    <h3 class="font-semibold mb-4">List Kategori</h3>

    <div class="box-body mb-4">

        <div class="mb-4">
            <label for="tanggal">Tanggal</label>
            <x-zara.input-date wire:model="date" />

            <x-zara.text-error :name="__('date')" />
        </div>

        <div class="mb-4">
            <label for="type">Type</label>

            <input type="hidden" wire:model="type">

            <div class="flex gap-2">
                <div class="basis-6/12">
                    <x-zara.button-primary-outline wire:click="setType('income')"
                        @class([
                            'underline bg-blue-600 text-white' => $type == 'income',
                        ])>Pemasukan</x-zara.button-primary-outline>
                </div>

                <div class="basis-6/12">
                    <x-zara.button-primary-outline wire:click="setType('spending')"
                        @class([
                            'underline bg-blue-600 text-white' => $type == 'spending',
                        ])>Pengeluaran</x-zara.button-primary-outline>
                </div>
            </div>

            <x-zara.text-error :name="__('type')" />
        </div>

        <div class="mb-4">
            <label for="category">Kategori</label>

            <select wire:model="category" id="category"
                class="w-full rounded-sm py-1 px-2 text-[14px] focus:ring-none focus:outline-none">
                <option>-- pilih --</option>
                @foreach ($listSelectCategory as $key)
                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                @endforeach
            </select>

            <x-zara.text-error :name="__('category')" />
        </div>

        <div class="mb-2">
            <label for="total">Jumlah</label>
            <input type="text" id="total" wire:model="total" wire:keyUp="setTotal"
                class="w-full rounded-sm py-1 px-2 text-[14px] focus:ring-none focus:outline-none" placeholder="0"
                autocomplete="off">

            <x-zara.text-error :name="__('total')" />

            <p class="text-green-600">{{ 'Rp ' . number_format($showTotal) }}</p>
        </div>

        <div class="mb-4">
            <label for="description">Deskripsi</label>
            <x-zara.input-text placeholder="Deskripsi" wire:model="description" />

            <x-zara.text-error :name="__('description')" />
        </div>

    </div>

    <div class="box-footer flex gap-2 justify-end">
        <div class="basis-3/12">
            <x-zara.link-button-danger href="/">Batal</x-zara.link-button-danger>
        </div>

        <div class="basis-3/12">
            <x-zara.button-primary wire:click="doCreateTransaction">Simpan</x-zara.button-primary>
        </div>
    </div>
</section>
