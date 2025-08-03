@extends('layouts.app')
@section('content')
    <style>
        .img-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .center-image {
            max-width: 100%;
            height: auto;
        }
    </style>

    @foreach (\App\Models\Patient::all() as $pat)
        {{ $pat->name }}<br>
    @endforeach

    {{-- <div class="img-container"> <img class="center-image img-thumbnail" src="{{ asset('assets/img/unnathi-logo.jpg') }}"
            alt="" srcset=""></div> --}}
@endsection
