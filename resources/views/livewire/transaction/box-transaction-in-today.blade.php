<section class="mb-4 shadow-lg shadow-slate-300 hover:shadow-slate-500 border-l-4 border-blue-400 rounded-lg">

    <div class="head p-3 underline">
        {{ date('j F Y') }}
    </div>

    <div>
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Kategori</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Deskripsi</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Pemasukan</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center">Pengeluaran</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-center"></th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @php
                    $totalIncome = 0;
                    $totalSpending = 0;
                @endphp
                @foreach ($transaction as $key)
                    @php
                        $totalIncome += $key->income;
                        $totalSpending += $key->spending;
                    @endphp

                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4 border-b border-gray-200 text-center">
                            <a href="/category/detail/{{ $key->category_code }}"
                                class="text-blue-500 hover:underline">{{ $key->category_name }}</a>
                        </td>
                        <td class="py-3 px-4 border-b border-gray-200">{{ $key->description }}</td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right text-green-500">
                            {{ $key->income == 0 ? '-' : number_format($key->income) }}
                        </td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right text-red-500">
                            {{ $key->spending == 0 ? '-' : number_format($key->spending) }}
                        </td>
                        <td class="py-1 px-4 border-b border-gray-200">
                            <div class="flex">

                                <div class="basis-6/12 p-1">
                                    <button wire:click="doEditTransaction('{{ $key->code }}')"
                                        class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Edit</button>
                                </div>

                                <div class="basis-6/12 p-1">
                                    <button wire:click="doDelete('{{ $key->code }}')"
                                        class="bg-red-500 hover:bg-red-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Hapus</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>

            <tfoot class="text-gray-700">
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b border-gray-200font-bold text-right" colspan="2">Grend
                        total
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-right text-green-500 font-bold">
                        {{ number_format($totalIncome) }}
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-right text-red-500 font-bold">
                        {{ number_format($totalSpending) }}
                    </td>
                    <td class="py-1 px-4 border-b border-gray-200">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex py-4 justify-center">
        <div class="basis-3/12">
            <button wire:click="doCreateTransaction"
                class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Tambah
                transaksi</button>
        </div>
    </div>

</section>
