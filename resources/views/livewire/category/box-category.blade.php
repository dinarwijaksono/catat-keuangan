<section class="mb-4 shadow-lg shadow-slate-300 hover:shadow-slate-500 border-l-4 border-blue-400 rounded-lg">

    <div class="p-3">
        <h3 class="font-semibold text-lg">List Kategori</h3>
    </div>

    <div class="mb-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Nama</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Type</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Dibuat</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center"></th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($categories as $key)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b border-gray-200 ">
                            <a href="#" class="text-blue-500 hover:underline">{{ $key->name }}</a>
                        </td>
                        <td class="py-3 px-4 border-b text-center border-gray-200">
                            <span
                                @class([
                                    'p-1 rounded-lg px-2 py-1 text-white text-[14px]',
                                    'bg-green-500' => $key->type == 'income',
                                    'bg-red-500' => $key->type == 'spending',
                                ])>{{ $key->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span>
                        </td>
                        <td class="py-3 px-4 border-b border-gray-200 text-center">
                            {{ date('j F Y', $key->created_at / 1000) }}</td>
                        <td class="py-1 px-4 border-b border-gray-200">
                            <div class="flex">
                                <button wire:click="doDelete('{{ $key->code }}')"
                                    class="bg-red-500 hover:bg-red-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Hapus</button>

                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>

    <div class="flex py-4 justify-center">
        <div class="basis-3/12">
            <button type="button" wire:click="doOpenFormCreateCategory"
                class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Tambah
                Kategori</button>
        </div>
    </div>
</section>
