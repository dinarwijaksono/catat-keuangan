@extends('layouts.main')

@section('main-section')
    @livewire('home.transaction-in-day', ['date' => time()])

    <section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">

        <table aria-describedby="my-table" class="w-full text-slate-600 text-[16px] mb-4">
            <tr class="bg-yellow-300">
                <th class="py-1 px-2 border border-slate-300">Tanggal</th>
                <th class="py-1 px-2 border border-slate-300">Pemasukan</th>
                <th class="py-1 px-2 border border-slate-300">Pengeluaran</th>
                <th class="py-1 px-2 border border-slate-300"></th>
            </tr>

            @foreach ($transactionRecent as $item)
                <tr>
                    <td class="py-1 px-2 border border-slate-300 text-center">{{ date('j F Y', $item->date) }}</td>
                    <td class="py-1 px-2 border border-slate-300 text-right text-green-600">
                        {{ number_format($item->total_income) }}</td>
                    <td class="py-1 px-2 border border-slate-300 text-right text-red-600">
                        {{ number_format($item->total_spending) }}</td>
                    <td class="py-1 px-2 border border-slate-300">
                        <x-zara.link-button-success
                            href="/Home/detail-transaction/{{ $item->date }}">Detail</x-zara.link-button-success>
                    </td>
                </tr>
            @endforeach
        </table>

    </section>
@endsection
