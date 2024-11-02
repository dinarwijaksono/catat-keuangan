@extends('layouts.main')

@section('main-section')
    <div class="max-w-3xl mx-auto">

        @livewire('component.alert-success')

        @livewire('transaction.form-edit-transaction')


        @livewire('transaction.form-create-transaction', ['date' => microtime(true)])

        @livewire('home.transaction-in-day')

        <!-- Note 1 -->
        <div
            class="shadow-lg text-gray-800 shadow-slate-300 hover:shadow-slate-500 mb-4 bg-white p-4 rounded-lg border-l-4 border-blue-400">
            <div class="mb-4 font-semibold">23 Oktober 2024</div>

            <div class="flex justify-center">
                <table class="basis-11/12">
                    <tr class="border-b">
                        <td class="w-6/12 px-2">Pemasukan</td>
                        <td class="w-6/12 text-right px-2 text-green-500">120.000</td>
                    </tr>
                    <tr class="border-b">
                        <td class="w-6/12 px-2">Pengeluaran</td>
                        <td class="w-6/12 text-right px-2 text-red-500">120.000</td>
                    </tr>

                    <tr class="border-b font-bold">
                        <td class="w-6/12 px-2">Selisih</td>
                        <td class="w-6/12 text-right px-2 text-red-500">0</td>
                    </tr>
                </table>
            </div>

            <div class="flex mt-4 justify-end">
                <div class="basis-2/12 p-1">
                    <button class="bg-blue-500 hover:bg-blue-700 rounded-lg px-2 py-1 text-white w-full text-[14px]">Lihat
                        detail</button>
                </div>
            </div>

        </div>

    </div>
@endsection
