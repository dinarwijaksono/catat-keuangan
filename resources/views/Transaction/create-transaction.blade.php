@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('transaction.form-create-transaction', ['date' => $date])

    </section>
@endsection
