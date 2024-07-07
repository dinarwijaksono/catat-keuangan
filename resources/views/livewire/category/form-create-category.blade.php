<section class="box">
    <div class="box-header mb-4">
        <h3 class="title">Buat Kategori</h3>
    </div>

    <div class="box-body">

        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <x-zara.input-text id="name" placeholder="Nama" wire:model="categoryName" />
            @error('categoryName')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>

            <input type="hidden" wire:model="type">

            <div class="flex gap-2">
                <div class="basis-6/12">
                    <x-zara.radio-button-info wire:click="doSetType('income')"
                        @class(['underline' => $type == 'income'])>Pemasukan</x-zara.radio-button-info>
                </div>

                <div class="basis-6/12">
                    <x-zara.radio-button-info wire:click="doSetType('spending')"
                        @class(['underline' => $type == 'spending'])>Pengeluaran</x-zara.radio-button-info>
                </div>
            </div>

            @error('type')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group flex justify-end">
            <div class="basis-2/12">
                <x-zara.button-primary wire:click="doCreateCategory">Simpan</x-zara.button-primary>
            </div>

        </div>
</section>
