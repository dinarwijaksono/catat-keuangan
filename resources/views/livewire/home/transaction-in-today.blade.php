<section class="box">
    <div class="box-header">
        <h2 class='title'>Transaksi Hari Ini</h2>
    </div>

    <div class="box-body mb-2">
        <p class="text-right underline">{{ date('j F Y') }}</p>

        <table class="w-full mb-4" aria-describedby="my-table">
            <thead>
                <tr class="bg-slate-300">
                    <th class="p-1">Kategori - Deskrpisi</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php
                    $totalIncome = 0;
                    $totalSpending = 0;
                @endphp

                @foreach ($transactionToday as $key)
                    @php
                        $totalIncome += $key->income;
                        $totalSpending += $key->spending;
                    @endphp

                    <tr class="border-b border-slate-500 p-2">
                        <td class="px-2"><a href="#">{{ $key->category_name }}</a> - {{ $key->description }}
                        </td>
                        <td class="text-green-500 text-right px-4">
                            {{ $key->income != 0 ? number_format($key->income) : '-' }}</td>
                        <td class="text-red-500 text-right px-4">
                            {{ $key->spending != 0 ? number_format($key->spending) : '-' }}</td>
                        <td>
                            <div class="flex gap-2 px-2">
                                <div class="basis-6/12">
                                    <x-zara.link-button-success
                                        href="/edit-transaction/{{ $key->code }}">Edit</x-zara.link-button-success>
                                </div>

                                <div class="basis-6/12">
                                    <x-zara.button-danger
                                        wire:click="doDelete('{{ $key->code }}')">Hapus</x-zara.button-danger>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="bg-yellow-300">
                    <td class="font-bold text-center p-1">Total</td>
                    <td class="text-green-500 text-right px-4 font-bold">
                        {{ $totalIncome != 0 ? number_format($totalIncome) : '-' }}</td>
                    <td class="text-red-500 text-right px-4 font-bold">
                        {{ $totalSpending != 0 ? number_format($totalSpending) : '-' }}
                    </td>
                    <td></td>
                </tr>

            </tfoot>
        </table>

    </div>

    <div class="box-header">
        <x-zara.link-button-success href="/create-transaction">Tambah Transaksi</x-zara.link-button-success>
</section>
