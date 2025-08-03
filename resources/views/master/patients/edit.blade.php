@extends('layouts.app')
@section('content')
    @livewire('master.patient-form', ['patient' => $patient])
@endsection
