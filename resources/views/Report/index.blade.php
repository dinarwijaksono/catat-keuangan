@extends('layouts.main')

@section('main-section')
    @livewire('component.alert-success')

    @livewire('transaction.form-edit-transaction')

    @livewire('report.box-amount')

    @livewire('report.box-total-category-by-period')

    @livewire('report.box-transaction-by-period')
@endsection
