<section class="box">
    <div class="box-body mb-4">
        <table class="w-full mb-4" aria-describedby="my-table">
            <thead>
                <tr class="bg-slate-300">
                    <th class="p-1">Periode</th>
                    <th class="p-1">Tanggal</th>
                    <th class="p-1">Deskripsi</th>
                    <th>Nilai</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($showTransaction as $key)
                    <tr class="border-b border-slate-500 p-2">
                        <td class="px-2 text-center w-2/12">{{ $key->period_name }}</td>
                        <td class="px-2 text-center w-2/12">{{ date('d F Y', $key->date) }}</td>
                        <td class="px-2 w-2/12">{{ $key->description }}</td>
                        <td class="px-2 w-2/12 text-right">
                            {{ number_format($key->income == 0 ? $key->spending : $key->income) }}
                        </td>
                        <td class="p-1 w-2/12">
                            <div class="flex gap-2 px-2">
                                <x-zara.link-button-success
                                    href="/edit-transaction/{{ $key->code }}">Edit</x-zara.link-button-success>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="box-header flex gap-2 ">

        <div class="basis-8/12">
            <p class="text-sky-500 italic py-1">Transaksi {{ $curentPage * 20 - 20 + 1 }} -
                {{ $curentPage * 20 >= $totalTransaction ? $totalTransaction : $curentPage * 20 }} dari
                {{ $totalTransaction }}</p>
        </div>

        <div class="basis-2/12">
            <button type="button" wire:click="doPrevPage" @class([
                'border border-sky-500 px-2 py-1 text-sky-500 rounded w-full hover:bg-sky-500 hover:text-white',
                'border-slate-400 hover:bg-white hover:text-slate-400 text-slate-400' =>
                    $curentPage <= 1,
            ])>Prev</button>
        </div>

        <div class="basis-2/12">
            <button type="button" wire:click="doNextPage" @class([
                'border border-sky-500 px-2 py-1 text-sky-500 rounded w-full hover:bg-sky-500 hover:text-white',
                'border-slate-400 hover:bg-white hover:text-slate-400 text-slate-400' =>
                    $curentPage * 20 >= $totalTransaction,
            ])>Next</button>
        </div>

    </div>
</section>
