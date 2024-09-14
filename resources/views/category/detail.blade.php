@extends('layouts.main')

@section('main-section')
    <section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">

        <section class="box">
            <div class="box-header mb-4">
                <h2 class="title">Detail Kategori</h2>
            </div>

            <div class="box-body mb-4">

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

                        <tr>
                            <th class="text-left w-2/12">Diedit</th>
                            <td class="text-center w-1/12">:</td>
                            <td class="w-9/12">{{ date(' H:i - d F Y', $category->updated_at / 1000) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="box-footer flex gap-2 justify-end mb-4">

                <div class="basis-2/12">
                    <x-zara.link-button-danger href="/">Kembali</x-zara.link-button-danger>
                </div>

                <div class="basis-2/12">
                    <x-zara.link-button-success
                        href="/edit-category/{{ $category->code }}">Edit</x-zara.link-button-success>
                </div>

            </div>

        </section>

        @livewire('category.box-transaction-by-category', ['categoryCode' => $categoryCode])

    </section>
@endsection
