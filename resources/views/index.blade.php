@extends('layouts.app')
@section('title', 'Xevos - databaze zamestnancu')

@section('content')
    <div class="flex justify-center w-full">
        <div class="w-4/5 max-w-6xl">
            @livewire('salaries-table')
        </div>
    </div>
@endsection
