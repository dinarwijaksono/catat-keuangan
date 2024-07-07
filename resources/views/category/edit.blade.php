@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success')

        @livewire('category.form-edit-category', ['code' => $categoryCode])

    </section>
@endsection
