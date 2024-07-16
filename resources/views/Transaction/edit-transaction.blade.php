@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('transaction.form-edit-transaction', ['code' => $transaction_code])

    </section>
@endsection
