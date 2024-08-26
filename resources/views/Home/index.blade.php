@extends('layouts.main')

@section('main-section')
    <section class="bg-white rounded-sm shadow p-4 mx-4 mb-4">
        <p class="text-[14px] mb-4">Senin, 12 April 2024</p>

        <table class="w-full mb-4" aria-describedby="my-table">
            <tr class="sm:hidden">
                <th>Kategori - Deskripsi</th>
                <th>Nilai</th>
            </tr>

            <tr class="border-b">
                <td class="py-1"><a href="" class="text-blue-500">Makanan</a> - Makan siang</td>
                <td class="text-right text-red-600">10.000</td>
            </tr>

            <tr class="border-b">
                <td class="py-1"><a href="" class="text-blue-500">Gaji</a> - Gaji</td>
                <td class="text-right text-green-600">10.000</td>
            </tr>

        </table>

        <table aria-describedby="my-table" class="mb-4 w-full rounded-sm shadow-sm">
            <tr class="bg-yellow-300 ">
                <th class="font-normal w-4/12 border py-1 text-[14px]">Pemasukan</th>
                <th class="font-normal w-4/12 border py-1 text-[14px]">Pengeluaran</th>
                <th class="font-normal w-4/12 border py-1 text-[14px]">Selisih</th>
            </tr>

            <tr>
                <td class="text-center border p-1 text-green-600">10.000</td>
                <td class="text-center border p-1 text-red-600">10.000</td>
                <td class="text-center border p-1">10.000</td>
            </tr>
        </table>

        <button class="mb-4 my-4 bg-green-600 hover:bg-green-700 rounded-sm text-white py-1 w-full text-[14x]">Tambah
            Transaksi</button>

    </section>
@endsection
