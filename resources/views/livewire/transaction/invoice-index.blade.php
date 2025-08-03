<div class="container">
    <div class="card card-body p-2 mb-2">
        <form wire:submit.prevent="filter">
            <div class="row mb-3">
                <div class="col">
                    <label for="">From</label>
                    <input type="text" wire:model.defer="fromDate" class="form-select form-select-sm date-component"
                        placeholder="From Date">
                </div>
                <div class="col">
                    <label for="">To</label>
                    <input type="text" wire:model.defer="toDate" class="form-select form-select-sm date-component"
                        placeholder="To Date">
                </div>
                <div class="col">
                    <label for="">Show Invoice Items</label>
                    <select wire:model.defer="showItems" class="form-select form-select-sm">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-primary" wire:click="filter">Filter</button>
                </div>
        </form>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body p-2 table-responsive">
                <span class="h5">List of {{ $type->name }}</span> <input type="text" id="searchInput" autofocus
                    placeholder="Search..." onkeyup="filterTable()" value="" class="form-select form-select-sm">
                <a class="btn btn-sm btn-primary" href="{{ route('invoice_create', [$type->slug]) }}">Add
                    {{ $type->name }}</a>
                <table class="table table-bordered table-sm mt-3" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">Series</th>
                            <th style="width: 8%">Date</th>
                            <th style="width: 10%">Invoice#</th>
                            <th style="width: 15%">Account</th>
                            <th style="width: 20%">Item Details</th>
                            <th style="width: 5%">Quantity</th>
                            <th style="width: 5%">Unit</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Amount</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = $invoices->sum(fn($inv) => $inv->getInvoiceTotal());
                        @endphp
                        @foreach ($invoices as $inv)
                            <tr class="invList" x-data
                                @dblclick="window.location='{{ route('invoice_edit', [$inv->invoiceType->slug, $inv->id]) }}'">
                                <td>{{ $inv->series->name }}</td>
                                <td>{{ Illuminate\Support\Carbon::parse($inv->invoice_date)->format('d-m-Y') }}</td>
                                <td>{{ $inv->invoice_number }}</td>
                                <td>{{ $inv->account->name }}</td>
                                <td>@php $itms = $inv->items @endphp</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">
                                    {{ rupees($inv->getInvoiceTotal()) }}
                                </td>
                            </tr>
                            @if ($showItems == 'yes')
                                @foreach ($itms as $it)
                                    <tr x-data
                                        @dblclick="window.location='{{ route('invoice_edit', [$inv->invoiceType->slug, $inv->id]) }}'">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $it->item->name }}</td>
                                        <td class="text-end">{{ $it->quantity }}</td>
                                        <td>{{ $it->uom->name }}</td>
                                        <td class="text-end">{{ rupees($it->price) }}</td>
                                        <td class="text-end">{{ rupees($it->price * $it->quantity) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end h6">
                                {{ rupees($totalAmount) }}
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function filterTable() {
                let input = document.getElementById('searchInput');
                let filter = input.value.toLowerCase();
                let table = document.getElementById('dataTable');
                let tr = table.getElementsByTagName('tr');

                for (let i = 0; i < tr.length; i++) {
                    let td = tr[i].getElementsByTagName('td');
                    let found = false;
                    for (let j = 0; j < td.length; j++) {
                        let cell = td[j];
                        if (cell) {
                            let text = cell.textContent || cell.innerText;
                            if (text.toLowerCase().indexOf(filter) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }
                    tr[i].style.display = found ? '' : 'none';
                }
            }

            // Ensure date inputs are formatted on change
            document.querySelectorAll('.date-component').forEach(input => {
                input.addEventListener('change', function() {
                    let value = this.value.trim();
                    if (value) {
                        let parts = value.split('-');
                        if (parts.length === 2 || parts.length === 3) {
                            let day = parts[0].padStart(2, '0');
                            let month = parts[1].padStart(2, '0');
                            let year = parts[2] || new Date().getFullYear().toString();
                            if (year.length === 2) year = '20' + year;
                            this.value = `${day}-${month}-${year}`;
                            // Dispatch input event to update Livewire
                            this.dispatchEvent(new Event('input', {
                                bubbles: true
                            }));
                        }
                    }
                });
            });
        });
    </script>
@endpush
