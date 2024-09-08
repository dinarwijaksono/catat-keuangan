@extends('layouts.main')

@section('main-section')
    @livewire('home.transaction-in-day', ['date' => time()])
@endsection
