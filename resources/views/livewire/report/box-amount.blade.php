<section class="mb-4 shadow-lg shadow-slate-300 border-l-4 border-blue-400 rounded-lg">

    <table class="min-w-full bg-white">
        <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
            <th class="py-3 px-4 border-b border-gray-200 text-center">Deskripsi</th>
            <th class="py-3 px-4 border-b border-gray-200 text-center">Nilai</th>
        </tr>

        <tr>
            <td class="py-3 px-4 border-b border-gray-200">Total Pemasukan</td>
            <td class="py-3 px-4 border-b border-gray-200 text-right font-bold text-green-500">
                {{ $this->amount->total_income == null ? 0 : number_format($this->amount->total_income, 0) }}</td>
        </tr>

        <tr>
            <td class="py-3 px-4 border-b border-gray-200">Total Pengeluaran</td>
            <td class="py-3 px-4 border-b border-gray-200 text-right text-red-500 font-bold">
                {{ $this->amount->total_spending == null ? 0 : number_format($this->amount->total_spending, 0) }}</td>
        </tr>

        <tr class="bg-yellow-100">
            <td class="py-3 px-4 border-b border-gray-200">Selisih</td>
            <td @class([
                'py-3 px-4 border-b border-gray-200 text-right font-bold',
                'text-red-500' =>
                    $this->amount->total_income < $this->amount->total_spending,
                'text-green-500' =>
                    $this->amount->total_income > $this->amount->total_spending,
            ])>
                {{ number_format($this->amount->total_income - $this->amount->total_spending, 0) }}
            </td>
        </tr>
    </table>

</section>
