@extends('layouts.main')

@section('main-section')
    <section class="content">

        <section class="box">
            <div class="box-header">
                <h2 class='title'>Transaksi Hari Ini</h2>
            </div>

            <div class="box-body mb-2">
                <p class="text-right underline">{{ date('j F Y') }}</p>

                <table class="w-full mb-4" aria-describedby="my-table">
                    <thead>
                        <tr>
                            <th>Kategori - Deskrpisi</th>
                            <th colspan="2">Nilai</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b border-slate-500 p-2">
                            <td><a href="#">Makanan</a> - sate</td>
                            <td class="text-green-500">10.000</td>
                            <td class="text-red-500">-</td>
                            <td>
                                <div class="flex gap-2">
                                    <div class="basis-6/12">
                                        <x-zara.button-primary>Edit</x-zara.button-primary>
                                    </div>

                                    <div class="basis-6/12">
                                        <x-zara.button-danger>Hapus</x-zara.button-danger>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-slate-500 p-2">
                            <td>Makanan - sate</td>
                            <td class="text-green-500">10.000</td>
                            <td class="text-red-500">-</td>
                            <td>
                                <div class="flex gap-2">
                                    <div class="basis-6/12">
                                        <x-zara.button-primary>Edit</x-zara.button-primary>
                                    </div>

                                    <div class="basis-6/12">
                                        <x-zara.button-danger>Hapus</x-zara.button-danger>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-slate-500 p-2">
                            <td>Makanan - sate</td>
                            <td>10.000</td>
                            <td>-</td>
                            <td>
                                <div class="flex gap-2">
                                    <div class="basis-6/12">
                                        <x-zara.button-primary>Edit</x-zara.button-primary>
                                    </div>

                                    <div class="basis-6/12">
                                        <x-zara.button-danger>Hapus</x-zara.button-danger>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="bg-yellow-300">
                            <td class="font-bold text-center p-1">Total</td>
                            <td class="text-green-500 font-bold">10.000</td>
                            <td class="text-red-500 font-bold">-</td>
                            <td></td>
                        </tr>

                    </tfoot>
                </table>

            </div>

            <div class="box-header">
                <x-zara.link-button-success href="/create-transaction">Tambah Transaksi</x-zara.link-button-success>
        </section>

    </section>
@endsection
