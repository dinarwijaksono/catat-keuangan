@extends('layouts.main')

@section('main-section')
    <section class="mb-4 shadow-lg shadow-slate-300 hover:shadow-slate-500 border-l-4 border-blue-400 rounded-lg p-4">

        <section class="box">
            <div class="box-header mb-8">
                <h3 class="font-bold text-xl">Detail Kategori</h3>
            </div>

            <div class="box-body mb-2">

                <table class="w-full" aria-describedby="my-table">
                    <tbody>
                        <tr>
                            <th class="text-left w-2/12">Nama</th>
                            <td class="text-center w-1/12">:</td>
                            <td class="w-9/12">{{ $category->name }}</td>
                        </tr>

                        <tr>
                            <th class="text-left w-2/12">Type</th>
                            <td class="text-center w-1/12">:</td>
                            <td class="w-9/12">{{ $category->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                        </tr>

                        <tr>
                            <th class="text-left w-2/12">Dibuat</th>
                            <td class="text-center w-1/12">:</td>
                            <td class="w-9/12">{{ date(' H:i - d F Y', $category->created_at / 1000) }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="box-footer flex gap-2 justify-end mb-2">

                <div class="basis-2/12">
                    <x-zara.link-button-danger href="/category">Kembali</x-zara.link-button-danger>
                </div>

            </div>

        </section>

        @livewire('category.box-transaction-by-category', ['categoryCode' => $categoryCode])

    </section>
@endsection
