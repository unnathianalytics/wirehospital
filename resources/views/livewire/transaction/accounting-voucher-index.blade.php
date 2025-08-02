@push('body-styles')
    <style>
        body {
            background-color: {{ $bg_color ?? '#FFFFFF' }};
        }
    </style>
@endpush
<div class="container">
    <form wire:submit.prevent>
        <div class="row mb-3">
            <div class="col">
                <input type="date" wire:model.defer="fromDate" class="form-control" placeholder="From Date">
            </div>
            <div class="col">
                <input type="date" wire:model.defer="toDate" class="form-control" placeholder="To Date">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary" wire:click="$refresh">Filter</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <span class="h5">List of {{ $type->name }}</span> <input type="text" id="searchInput" autofocus
                    placeholder="Search..." onkeyup="filterTable()" value=""> <a class="btn btn-sm btn-primary"
                    href="{{ route('accounting_voucher_create', [$type->slug]) }}">Add
                    {{ $type->name }}</a>
                <table class="table table-bordered table-hover table-sm mt-3" id="dataTable">
                    <thead>
                        <tr>
                            <th style="">Series</th>
                            <th style="">Date</th>
                            <th style="">Invoice#</th>
                            <th>Total Amount</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accountingVouchers as $acv)
                            <tr class="invList" x-data
                                @dblclick="window.location='{{ route('accounting_voucher_edit', [$acv->accountingType->slug, $acv->id]) }}'">
                                <td>{{ $acv->transaction_date }}</td>
                                <td>{{ $acv->voucher_number }}</td>
                                <td>{{ $acv->description }}</td>
                                <td>{{ $acv->description }}</td>
                                <td>@php $accAcc = $acv->accountingVoucherItems @endphp</td>
                            </tr>
                            @foreach ($accAcc as $det)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $det->credit_acc->name ?? '' }}</td>
                                    <td>{{ $det->debit_acc->name ?? '' }}</td>
                                    <td class="text-end">{{ rupees($det->cr_amount) }}</td>
                                    <td class="text-end">{{ rupees($det->dr_amount) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
