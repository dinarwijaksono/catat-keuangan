@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success', [
            'isHidden' => session()->missing('alert-success'),
            'message' => session()->get('alert-success'),
        ])

        @livewire('home.transaction-in-today')

        <section class="box">
            <div class="box-body border-b">

                <table class="table-simple w-full" aria-describedby="my-table">
                    <thead>
                        <tr class="bg-yellow-300">
                            <th>Tanggal</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Selisih</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transactionRecent as $key)
                            <tr class="hover:bg-slate-200">
                                <td class="text-center">{{ date('d F Y', $key->date) }}</td>
                                <td class="text-right text-green-500">
                                    {{ $key->total_income == 0 ? '-' : number_format($key->total_income) }}</td>
                                <td class="text-right text-red-500">
                                    {{ $key->total_spending == 0 ? '-' : number_format($key->total_spending) }}</td>
                                <td @class([
                                    'text-right',
                                    'text-green-500' => $key->total_income - $key->total_spending > 0,
                                    'text-red-500' => $key->total_income - $key->total_spending < 0,
                                ])>
                                    {{ number_format($key->total_income - $key->total_spending) }}</td>
                                <td>
                                    <x-zara.link-button-success
                                        href="/detail-transaction/{{ $key->date }}">Detail</x-zara.link-button-success>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </section>

    </section>
@endsection
