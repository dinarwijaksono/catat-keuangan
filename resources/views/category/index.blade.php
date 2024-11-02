@extends('layouts.main')

@section('main-section')
    <div class="max-w-3xl mx-auto">

        @livewire('component.alert-success')

        @livewire('category.form-create-category')

        @livewire('category.box-category')

    </div>
@endsection
