@extends('layouts.main')

@section('main-section')
    <section class="content">

        @livewire('component.alert-success')
        @livewire('component.alert-danger')

        @livewire('category.box-category')

        @livewire('category.form-create-category')


    </section>
@endsection
