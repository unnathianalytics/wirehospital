@extends('layouts.app')
@section('content')
    @livewire('patient.ehr-form', ['patient' => $patient])
@endsection
