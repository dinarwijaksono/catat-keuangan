<div>
    @foreach ($transactionRecent as $key)
        <section
            class="shadow-lg text-gray-800 shadow-slate-300 hover:shadow-slate-500 mb-4 bg-white p-4 rounded-lg border-l-4 border-blue-400">
            <div class="mb-4 font-semibold">{{ date('j F Y', $key->date) }}</div>

            <div class="flex justify-center">
                <table class="basis-11/12">
                    <tr class="border-b">
                        <td class="w-6/12 px-2">Pemasukan</td>
                        <td class="w-6/12 text-right px-2 text-green-500">{{ number_format($key->total_income) }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="w-6/12 px-2">Pengeluaran</td>
                        <td class="w-6/12 text-right px-2 text-red-500">{{ number_format($key->total_spending) }}</td>
                    </tr>

                    <tr class="border-b font-bold">
                        <td class="w-6/12 px-2">Selisih</td>
                        <td class="w-6/12 text-right px-2 text-red-500">
                            {{ number_format($key->total_income - $key->total_spending) }}</td>
                    </tr>
                </table>
            </div>

            <div class="flex mt-4 justify-end">
                <div class="basis-2/12 p-1">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Lihat
                        detail</button>
                </div>
            </div>
        </section>
    @endforeach
</div>
