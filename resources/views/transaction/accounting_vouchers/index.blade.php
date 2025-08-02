@extends('layouts.app')
@section('content')
    @livewire('transaction.accounting-voucher-index', [
        'accountingType' => $accountingType,
        'accounting_type_id' => $accounting_type_id,
    ])
@endsection
