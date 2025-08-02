<div class="container">
    <div class="row">
        <div class="col-lg-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-lg-9">
            <form wire:submit.prevent="save" class="">
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label>Transaction Date</label>
                        <input type="date" wire:model="accountingVoucherData.transaction_date"
                            class="form-control" />
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label>Voucher Number</label>
                        <input type="text" wire:model="accountingVoucherData.voucher_number" class="form-control" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label>Notes</label>
                        <input wire:model="accountingVoucherData.voucher_notes" class="form-control" />
                    </div>
                </div>
                <hr />
                <div class="table-responsive scrollable-table">
                    <div style="min-height: 200px; max-height: 200px; overflow-y: scroll;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cr/Dr</th>
                                    <th>Account</th>
                                    <th>Cr Amount</th>
                                    <th>Dr Amount</th>
                                    <th>Short Narration</th>
                                    <th style="width: 5%;">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accountingVoucherItems as $index => $item)
                                    <tr>
                                        <td style="width: 10%">
                                            <select
                                                wire:model.live="accountingVoucherItems.{{ $index }}.avr_item_type"
                                                class="form-select" required>
                                                <option value="">-- Select Type --</option>
                                                <option value="cr">Credit</option>
                                                <option value="dr">Debit</option>
                                            </select>
                                        </td>
                                        <td style="width: 30%">
                                            @if ($item['avr_item_type'] === 'cr')
                                                <select
                                                    wire:model="accountingVoucherItems.{{ $index }}.cr_account_id"
                                                    class="form-control">
                                                    <option value="">-- Cr Account --</option>
                                                    @foreach ($cr_accounts as $acc)
                                                        <option value="{{ $acc->id }}">{{ $acc->name }} |
                                                            {{ $acc->parent->name ?? 'No Parent' }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($item['avr_item_type'] === 'dr')
                                                <select
                                                    wire:model="accountingVoucherItems.{{ $index }}.dr_account_id"
                                                    class="form-control">
                                                    <option value="">-- Dr Account --</option>
                                                    @foreach ($dr_accounts as $acc)
                                                        <option value="{{ $acc->id }}">{{ $acc->name }} |
                                                            {{ $acc->parent->name ?? 'No Parent' }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select class="form-control" disabled>
                                                    <option value="">-- Select Type First --</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td style="width: 15%">
                                            <input type="number" step="0.01"
                                                wire:model.live="accountingVoucherItems.{{ $index }}.cr_amount"
                                                class="form-control text-end" placeholder="Cr Amount"
                                                @if ($item['avr_item_type'] !== 'cr') disabled style="width: 0px; height: 0px;" @endif />
                                        </td>
                                        <td style="width: 15%">
                                            <input type="number" step="0.01"
                                                wire:model.live="accountingVoucherItems.{{ $index }}.dr_amount"
                                                class="form-control text-end" placeholder="Dr Amount"
                                                @if ($item['avr_item_type'] !== 'dr') disabled style="width: 0px; height: 0px;" @endif />
                                        </td>
                                        <td style="width: 20%">
                                            <input type="text"
                                                wire:model="accountingVoucherItems.{{ $index }}.description"
                                                class="form-control" placeholder="Short Narration" />
                                        </td>
                                        <td>
                                            <button type="button" wire:click="removeRow({{ $index }})"
                                                class="btn btn-danger btn-sm">-</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end h6">
                                        {{ rupees(collect($accountingVoucherItems)->sum('cr_amount')) }}
                                    </td>
                                    <td class="text-end h6">
                                        {{ rupees(collect($accountingVoucherItems)->sum('dr_amount')) }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div>
                        <button type="button" wire:click="addRow" class="btn btn-secondary">+ Add Row</button>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Voucher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
