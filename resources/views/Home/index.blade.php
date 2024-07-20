@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success', [
            'isHidden' => session()->missing('alert-success'),
            'message' => session()->get('alert-success'),
        ])

        @livewire('home.transaction-in-today')

    </section>
@endsection
