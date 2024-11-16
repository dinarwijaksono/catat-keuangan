<section class="mb-4 shadow-lg shadow-slate-300 border-l-4 border-blue-400 rounded-lg">

    @if ($transaction != null)

        <div class="mb-4 flex gap-1 p-4">
            <div class="basis-10/12 p-1">
                <select wire:model="periodSelect" class="w-full px-2 py-1 rounded text-[14px]">
                    @foreach ($listPeriod as $period)
                        <option value="{{ $period->id }}">{{ $period->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="basis-2/12 p-1">
                <x-zara.button-primary wire:click="doSelectPeriod"
                    class="border-2 border-blue-500 hover:border-blue-600">Cari</x-zara.button-primary>
            </div>
        </div>

        <hr class="mx-4">

        <div class="mb-8">
            <h3 class="font-bold mx-4 mt-4 mb-2 underline">Kategori Pemasukan</h3>

            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-green-500 text-white uppercase">
                        <th class="py-1 px-2">Kategori</th>
                        <th class="py-1 px-2">Nilai</th>
                    </tr>
                </thead>

                @php
                    $totalIncome = 0;
                @endphp

                @foreach ($transaction as $key)
                    @if ($key->total_income != 0)
                        @php
                            $totalIncome += $key->total_income;
                        @endphp

                        <tr class="border-b">
                            <td class="py-3 px-4 border-b border-gray-200">{{ $key->category_name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-right font-bold text-green-500">
                                {{ number_format($key->total_income, 0) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tfoot>
                    <tr class="bg-green-300 font-bold">
                        <td class="py-3 px-4 border-b border-gray-200">total</td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right">
                            {{ number_format($totalIncome, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mb-4">
            <h3 class="font-bold mx-4 mt-4 mb-2 underline">Kategori pengeluaran</h3>

            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-red-500 text-white uppercase">
                        <th class="py-1 px-2">Kategori</th>
                        <th class="py-1 px-2">Nilai</th>
                    </tr>
                </thead>

                @php
                    $totalSpending = 0;
                @endphp

                @foreach ($transaction as $key)
                    @if ($key->total_spending != 0)
                        @php
                            $totalSpending += $key->total_spending;
                        @endphp

                        <tr class="border-b">
                            <td class="py-3 px-4 border-b border-gray-200">{{ $key->category_name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-right font-bold text-red-500">
                                {{ number_format($key->total_spending, 0) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tfoot>
                    <tr class="bg-red-300 font-bold">
                        <td class="py-3 px-4 border-b border-gray-200">total</td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right">
                            {{ number_format($totalSpending, 0) }}</td>
                    </tr>
                </tfoot>
            </table>

        </div>

    @endif
</section>
