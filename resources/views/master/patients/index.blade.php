@extends('layouts.app')
@php $patients = App\Models\Patient::orderBy('name')->get(); @endphp
@section('content')
    <div class="container">
        <h4>All Patients</h4>
        <input type="text" id="searchInput" autofocus placeholder="Search..." onkeyup="filterTable()" value=""> <a
            class="btn btn-sm btn-primary" href="{{ route('patient_create') }}">Add Patient</a>
        <table class="table table-bordered table-sm mt-3" id="dataTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Op Balane</th>
                    <th>Cr/Dr</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $pat)
                    <tr style="background-color: {{ $pat->cr_dr == 'cr' ? 'lightred' : '' }}" x-data
                        @dblclick="window.location='{{ route('patient_edit', $pat->id) }}'">
                        <td>{{ $pat->name }}</td>
                        <td>{{ $pat->parent->name ?? '-' }}</td>
                        <td class="text-end">{{ rupees($pat->op_balance) }}</td>
                        <td>{{ ucwords($pat->cr_dr) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No Patients found.</td>
                    </tr>
                @endforelse
                @for ($i = $patients->count(); $i < 20; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection
