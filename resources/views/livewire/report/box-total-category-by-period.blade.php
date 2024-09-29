<section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">

    @if ($transaction != null)
        <div class="mb-4">
            <h3 class="font-bold mb-2 underline">Kategori Pemasukan</h3>

            <table class="w-full" aria-describedby="my-table">
                <tr class="bg-green-600 text-white">
                    <th class="py-1 px-2">Kategori</th>
                    <th class="py-1 px-2">Nilai</th>
                </tr>

                @php
                    $totalIncome = 0;
                @endphp

                @foreach ($transaction as $key)
                    @if ($key->total_income != 0)
                        @php
                            $totalIncome += $key->total_income;
                        @endphp

                        <tr class="border-b">
                            <td class="py-1 px-2">{{ $key->category_name }}</td>
                            <td class="py-1 px-2 text-right">{{ number_format($key->total_income, 0) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tr class="bg-green-300 font-bold">
                    <td class="py-1 px-2">total</td>
                    <td class="py-1 px-2 text-right">{{ number_format($totalIncome, 0) }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-4">
            <h3 class="font-bold mb-2 underline">Kategori pengeluaran</h3>

            <table class="w-full" aria-describedby="my-table">
                <tr class="bg-red-600 text-white">
                    <th class="py-1 px-2">Kategori</th>
                    <th class="py-1 px-2">Nilai</th>
                </tr>

                @php
                    $totalSpending = 0;
                @endphp

                @foreach ($transaction as $key)
                    @if ($key->total_spending != 0)
                        @php
                            $totalSpending += $key->total_spending;
                        @endphp

                        <tr class="border-b">
                            <td class="py-1 px-2">{{ $key->category_name }}</td>
                            <td class="py-1 px-2 text-right">{{ number_format($key->total_spending, 0) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tr class="bg-red-300 font-bold">
                    <td class="py-1 px-2">total</td>
                    <td class="py-1 px-2 text-right">{{ number_format($totalSpending, 0) }}</td>
                </tr>
            </table>
        </div>
    @endif

</section>
