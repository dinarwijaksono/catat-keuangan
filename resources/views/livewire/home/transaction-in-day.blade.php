<section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">
    <p class="text-[14px] mb-4">{{ date('j F Y', $date) }}</p>

    <table class="w-full mb-4" aria-describedby="my-table">
        <tr class="sm:hidden">
            <th>Kategori - Deskripsi</th>
            <th>Nilai</th>
            <th></th>
        </tr>

        @php
            $incomeTotal = 0;
            $spendingTotal = 0;
        @endphp

        @foreach ($transaction as $key)
            <tr class="border-b">
                <td class="py-1"><a href="/category/detail/{{ $key->category_code }}"
                        class="text-blue-500">{{ $key->category_name }}</a> -
                    {{ $key->description }}</td>
                <td @class([
                    'text-right',
                    'text-green-600' => $key->income != 0,
                    'text-red-500' => $key->spending != 0,
                ])>
                    {{ $key->income != 0 ? number_format($key->income) : number_format($key->spending) }}</td>
                <td>
                    <x-zara.button-danger type="button" wire:click="doDelete('{{ $key->code }}')"
                        class="m-1">Hapus</x-zara.button-danger>
                </td>
            </tr>

            @php
                $incomeTotal += $key->income;
                $spendingTotal += $key->spending;
            @endphp
        @endforeach

    </table>

    <table aria-describedby="my-table" class="mb-4 w-full rounded-sm shadow-sm">
        <tr class="bg-yellow-300 ">
            <th class="font-normal w-4/12 border py-1 text-[14px]">Pemasukan</th>
            <th class="font-normal w-4/12 border py-1 text-[14px]">Pengeluaran</th>
            <th class="font-normal w-4/12 border py-1 text-[14px]">Selisih</th>
        </tr>

        <tr>
            <td class="text-center border p-1 text-green-600">{{ number_format($incomeTotal) }}</td>
            <td class="text-center border p-1 text-red-600">{{ number_format($spendingTotal) }}</td>
            <td class="text-center border p-1">{{ number_format($incomeTotal - $spendingTotal) }}</td>
        </tr>
    </table>

    <a href="/create-transaction/{{ $date }}"
        class="block text-center mb-4 my-4 bg-green-600 hover:bg-green-700 rounded-sm text-white py-1 w-full text-[14x]">Tambah
        Transaksi</a>

</section>
