@extends('layouts.main')

@section('main-section')
    <div class="max-w-3xl mx-auto">

        @livewire('component.alert-success')

        @livewire('transaction.form-edit-transaction')

        @livewire('transaction.form-create-transaction', ['date' => microtime(true)])

        @if (isset($_GET['date']) && is_numeric($_GET['date']))
            @livewire('transaction.box-transaction-in-day', ['date' => $_GET['date']])
        @endif

        @livewire('transaction.box-transaction-in-today')

        @livewire('transaction.transaction-in-period')

    </div>
@endsection
