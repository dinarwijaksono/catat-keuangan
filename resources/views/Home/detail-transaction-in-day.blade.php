@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success')

        @livewire('home.transaction-in-day', ['date' => $date])

        <section class="flex justify-end">
            <div class="basis-3/12">
                <x-zara.link-button-danger href="/">Kembali</x-zara.link-button-danger>
            </div>
        </section>

    </section>
@endsection
