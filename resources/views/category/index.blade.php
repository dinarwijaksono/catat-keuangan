@extends('layouts.main')

@section('main-section')
    <section class="content">

        <section class="box">
            <div class="box-header mb-4">
                <h3 class="title">List Kategori</h3>
            </div>

            <div class="box-body">

                <table class="table-simple w-full" aria-describedby="my-table">
                    <tr>
                        <th style="width: 10">No</th>
                        <th>Nama</th>
                        <th>Type</th>
                        <th>Dibuat</th>
                        <th>Diedit</th>
                        <th></th>
                    </tr>
                </table>

            </div>
        </section>

        @livewire('category.form-create-category')


    </section>
@endsection
