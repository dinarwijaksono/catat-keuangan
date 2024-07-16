<section class="box">
    <div class="box-header mb-4">
        <h3 class="title">Edit Transaksi</h3>
    </div>

    <div class="box-body mb-4">

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" wire:model="date" id="tanggal">

            <x-zara.text-error :name="__('date')" />
        </div>

        <div class="form-group">
            <label for="type">Type</label>

            <input type="hidden" wire:model="type">

            <div class="flex gap-2">
                <div class="basis-6/12">
                    <x-zara.radio-button-info wire:click="setType('income')"
                        @class([
                            'underline' => $type == 'income',
                            'bg-slate-600' => $type == 'income',
                        ])>Pemasukan</x-zara.radio-button-info>
                </div>

                <div class="basis-6/12">
                    <x-zara.radio-button-info wire:click="setType('spending')"
                        @class([
                            'underline' => $type == 'spending',
                            'bg-slate-600' => $type == 'spending',
                        ])>Pengeluaran</x-zara.radio-button-info>
                </div>
            </div>

            <x-zara.text-error :name="__('type')" />
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>

            <select wire:model="category" id="category">
                @foreach ($listSelectCategory as $key)
                    @if ($key->code == $getTransaction->category_code)
                        <option value="{{ $key->id }}" selected>{{ $key->name }}</option>
                    @else
                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                    @endif
                @endforeach
            </select>

            <x-zara.text-error :name="__('category')" />
        </div>



        <div class="form-group">
            <label for="total">Jumlah</label>
            <input type="number" id="total" wire:keyDown="setTotal" wire:model="total" placeholder="0">

            <p class="text-green-700">Rp {{ number_format($showTotal) }}</p>

            <x-zara.text-error :name="__('total')" />
        </div>

        <div class="form-group">
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
            <x-zara.button-primary wire:click="doEdit">Simpan</x-zara.button-primary>
        </div>
    </div>
</section>
