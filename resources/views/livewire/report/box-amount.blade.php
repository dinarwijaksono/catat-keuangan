<section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">

    <table class="table w-full" aria-describedby="my-table">
        <tr class="bg-yellow-300">
            <th class="p-1">Deskripsi</th>
            <th class="p-1">Nilai</th>
        </tr>

        <tr>
            <td class="p-1">Pemasukan</td>
            <td class="text-right text-green-600 p-1">
                {{ $this->amount->total_income == null ? 0 : number_format($this->amount->total_income, 0) }}</td>
        </tr>

        <tr>
            <td class="p-1">Pengeluaran</td>
            <td class="text-right text-red-600 p-1">
                {{ $this->amount->total_spending == null ? 0 : number_format($this->amount->total_spending, 0) }}</td>
        </tr>

        <tr class="bg-yellow-100">
            <td class="p-1">Selisih</td>
            <td class="text-right font-bold p-1">
                {{ number_format($this->amount->total_income - $this->amount->total_spending, 0) }}
            </td>
        </tr>
    </table>

</section>
