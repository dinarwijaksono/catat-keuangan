@extends('layouts.main')

@section('main-section')
    <div class="max-w-3xl mx-auto">

        @livewire('component.alert-success')

        @livewire('transaction.form-edit-transaction')

        @livewire('transaction.form-create-transaction', ['date' => microtime(true)])

        @livewire('home.transaction-in-day')

        @livewire('transaction.transaction-in-period')


    </div>
@endsection
