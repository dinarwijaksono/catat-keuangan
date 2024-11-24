<section class="mb-4 shadow-lg shadow-slate-300 border-l-4 border-blue-400 rounded-lg">
    @if ($listTransaction != null)

        <div class="p-4">
            <h3 class="font-semibold">Transaksi berdasarkan periode</h3>
        </div>

        <div class="mb-1 flex gap-1 p-1 px-4">
            <div class="basis-6/12 p-1">
                <label for="">Periode</label>
                <select wire:model="periodSelect" class="w-full px-2 py-1 rounded text-[14px]">
                    @foreach ($listPeriod as $period)
                        <option value="{{ $period->id }}">{{ $period->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="basis-6/12 p-1">
                <label for="">Kategori</label>
                <select wire:model="categorySelect" class="w-full px-2 py-1 rounded text-[14px]">
                    <option value="all">Semua</option>

                    @foreach ($listCategory as $category)
                        <option value="{{ $category->code }}">
                            {{ $category->type == 'income' ? "(Pemasukan) $category->name" : "(Pengaluaran) $category->name" }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end mb-1 p-1 px-4">
            <div class="basis-2/12">
                <x-zara.button-primary wire:click="doSearchTransaction"
                    class="border-2 border-blue-500 hover:border-blue-600">Cari</x-zara.button-primary>
            </div>
        </div>

        <hr class="m-4">

        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-green-500 text-white uppercase">
                    <th class="py-1 px-2">Tanggal</td>
                    <th class="py-1 px-2">Kategori</td>
                    <th class="py-1 px-2">Deskripsi</td>
                    <th class="py-1 px-2">Pemasukan</td>
                    <th class="py-1 px-2">Pengeluaran</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($listTransaction as $transaction)
                    <tr class="border-b">
                        <td class="py-3 px-4 border-b border-gray-200">{{ date('j F Y', $transaction->date) }}</td>
                        <td class="py-3 px-4 border-b border-gray-200">
                            <a href="/category/detail/{{ $transaction->category_code }}"
                                class="text-blue-500 hover:underline">
                                {{ $transaction->category_name }}</a>
                        </td>
                        <td class="py-3 px-4 border-b border-gray-200">{{ $transaction->description }}</td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right text-green-500">
                            {{ number_format($transaction->income) }}</td>
                        <td class="py-3 px-4 border-b border-gray-200 text-right text-red-500">
                            {{ number_format($transaction->spending) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</section>
