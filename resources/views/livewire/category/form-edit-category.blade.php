<section class="box">
    <div class="box-header mb-4">
        <h3 class="title">Edit Kategori</h3>
    </div>

    <div class="box-body">

        <div class="form-group">
            <label for="CategoryName">Nama kategori</label>
            <x-zara.input-text wire:model="categoryName" placeholder="Nama kategori" />
            @error('categoryName')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <x-zara.input-text placeholder="Nama kategori" disabled class="text-slate-500"
                value="{{ $category->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}" />
        </div>

        <div class="form-group flex justify-end gap-2">
            <div class="basis-2/12">
                <x-zara.link-button-success href="/category">Batal</x-zara.link-button-success>
            </div>

            <div class="basis-2/12">
                <x-zara.button-primary wire:click="doUpdate">Edit</x-zara.button-primary>
            </div>
        </div>

    </div>
</section>
