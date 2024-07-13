@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success')

        @livewire('transaction.form-create-transaction')

    </section>
@endsection
