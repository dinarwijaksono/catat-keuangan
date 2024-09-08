@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('home.transaction-in-day', ['date' => $date])

        <section class="rounded-sm shadow mx-4 mb-4">
            <div class="basis-3/12">
                <x-zara.link-button-danger href="/">Kembali</x-zara.link-button-danger>
            </div>
        </section>

    </section>
@endsection
