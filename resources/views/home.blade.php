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
    <!DOCTYPE html>
    <html>

    <head>
        <title>Date Input Mask</title>
    </head>

    <body>
        <input type="text" class="date-component" id="dateInput" placeholder="dd-mm-yyyy">
    </body>

    </html>

    <div class="img-container"> <img class="center-image img-thumbnail" src="{{ asset('assets/img/unnathi-logo.jpg') }}"
            alt="" srcset=""></div>
@endsection
