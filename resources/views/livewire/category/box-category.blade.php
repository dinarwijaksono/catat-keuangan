<section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">
    <h3 class="font-semibold mb-4">List Kategori</h3>

    <div class="flex mb-4 gap-2">
        <div class="basis-6/12">
            <x-zara.button-primary-outline type="button" wire:click="toSetType('income')"
                @class([
                    'rounded-sm py-1 px-2 w-full text-[14px]',
                    'border border-blue-500 bg-blue-100 hover:bg-blue-700 text-blue-500 hover:text-white' =>
                        $type != 'income',
                    'border border-blue-500 bg-blue-500 hover:bg-blue-700 text-blue-500 text-white' =>
                        $type == 'income',
                ])>Pemasukan</x-zara.button-primary-outline>
        </div>

        <div class="basis-6/12">
            <x-zara.button-primary-outline type="button" wire:click="toSetType('spending')"
                @class([
                    'rounded-sm py-1 px-2 w-full text-[14px]',
                    'border border-blue-500 bg-blue-100 hover:bg-blue-700 text-blue-500 hover:text-white' =>
                        $type != 'spending',
                    'border border-blue-500 bg-blue-500 hover:bg-blue-700 text-blue-500 text-white' =>
                        $type == 'spending',
                ])>Pengeluaran</x-zara.button-primary-outline>
        </div>
    </div>

    <div class="mb-4">
        <table class="w-full mb-4" aria-describedby="my-table">
            <tr>
                <th class="font-normal w-9/12 border py-1 text-[14px]">Nama</th>
                <th class="font-normal w-3/12 border py-1 text-[14px]"></th>
            </tr>

            @foreach ($categories as $item)
                <tr>
                    <td class="border py-1 px-2"><a href="/category/detail/{{ $item->code }}"
                            class="text-blue-400 hover:underline">{{ $item->name }}</a>
                    </td>
                    <td class="border py-1 px-2">
                        <x-zara.button-danger type="button"
                            wire:click="doDelete('{{ $item->code }}')">Hapus</x-zara.button-danger>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <hr class="mb-4">

    <div class="mb-2">
        <h3 class="font-semibold mb-4">Buat kategori</h3>

        <div class="mb-2">
            <label for="name">Nama</label>
            <input type="text" id="name" wire:model="categoryName"
                class="w-full rounded-sm py-1 px-2 text-[14px] focus:ring-none focus:outline-none"
                placeholder="Nama kategori" autocomplete="off">
        </div>

        <div class="flex justify-end">
            <div class="w-3/12">
                <x-zara.button-primary type="button" wire:click="doCreateCategory">Simpan</x-zara.button-primary>
            </div>
        </div>
    </div>

</section>
