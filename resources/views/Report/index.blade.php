@extends('layouts.main')

@section('main-section')
    @livewire('report.box-amount')

    @livewire('report.box-total-category-by-period')

    @livewire('generate-data.form-import')
@endsection
