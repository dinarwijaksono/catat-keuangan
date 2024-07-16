@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success')

        @livewire('home.transaction-in-today')

    </section>
@endsection
