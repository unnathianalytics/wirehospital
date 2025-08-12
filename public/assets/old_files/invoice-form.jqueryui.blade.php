@push('body-styles')
    <style>
        .item-id-input {
            width: 0;
            height: 0;
            border: none;
            padding: 0;
            margin: 0;
            position: absolute;
            opacity: 0;
        }
    </style>
@endpush
<div class="container-fluid">
    <form wire:submit="save" id="invoice-form">
        <input type="hidden" wire:model="invoiceData.invoice_type_id">
        <div class="row mb-3">
            <div class="col-lg-10 card">
                <div class="row card-body">
                    <div class="col-lg-1 mb-3">
                        <label for="voucher_series_id" class="form-label">Series</label>
                        <select wire:model.live="invoiceData.voucher_series_id" class="form-select form-select-sm"
                            id="voucher_series_id">
                            <option value="">Select</option>
                            @foreach ($voucherSeries as $series)
                                <option value="{{ $series->id }}">{{ $series->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="invoice_date" class="form-label">Date</label>
                        <input type="text" id="invoice_date"
                            class="focusable form-select form-select-sm date-component"
                            wire:model.live="invoiceData.invoice_date" placeholder="yyyy-mm-dd"
                            data-max='{{ date('Y-m-d') }}' maxlength="10">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="invoice_number" class="form-label">Invoice Number</label>
                        <input type="text" id="invoice_number" class="form-select form-select-sm focusable"
                            wire:model="invoiceData.invoice_number">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="tax_type_id" class="form-label">Tax Type</label>
                        <select wire:model="invoiceData.tax_type_id" class="form-select form-select-sm focusable"
                            id="tax_type_id">
                            <option value="">Select</option>
                            @foreach ($taxTypes as $taxType)
                                <option value="{{ $taxType->id }}">{{ $taxType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label for="account_id" class="form-label">Party
                            <small class="text-sm text-danger">(Cur. Bal {{ $this->current_balance }})</small>
                        </label>
                        <select wire:model.live="invoiceData.account_id" class="form-select form-select-sm focusable"
                            id="account_id">
                            <option value="">Select</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="mc_id" class="form-label">Store</label>
                        <select wire:model="mc_id" class="form-select form-select-sm focusable" id="mc_id">
                            <option value="">Select</option>
                            @foreach ($allMCs as $mc)
                                <option value="{{ $mc->id }}">{{ $mc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive scrollable-table" style="min-height: 150px; max-height: 200px;">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 2%">#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>MRP</th>
                                    <th>Price (Rs.)</th>
                                    <th>Dis%</th>
                                    <th class="item-id-input">Dis (Total)</th>
                                    <th class="item-id-input">GST% (C+S+Cess)</th>
                                    <th style="width: 10%">Amount (Rs.)</th>
                                    <th style="width: 5%;">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceItems as $index => $item)
                                    <tr wire:key="row-{{ $index }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td style="width: 20%">
                                            <div wire:ignore>
                                                <input type="text"
                                                    class="form-select form-select-sm item-autocomplete"
                                                    data-index="{{ $index }}"
                                                    id="item_name_{{ $index }}"
                                                    value="{{ $item['item_name'] ?? '' }}"
                                                    placeholder="Search item...">
                                            </div>
                                            <input type="text" class="item-id-input"
                                                id="item_id_{{ $index }}"
                                                wire:model.debounce.500ms="invoiceItems.{{ $index }}.item_id">
                                        </td>
                                        <td style="width: 5%">
                                            <input type="number" style="text-align:right" step="0.01"
                                                placeholder="Qty" class="form-select form-select-sm focusable"
                                                id="quantity_{{ $index }}"
                                                wire:model.lazy="invoiceItems.{{ $index }}.quantity">
                                        </td>
                                        <td style="width: 5%">
                                            <select class="form-select form-select-sm focusable"
                                                wire:model="invoiceItems.{{ $index }}.uom_id">
                                                <option value=""></option>
                                                @if (!empty($itemUomOptions[$index]))
                                                    @foreach ($itemUomOptions[$index] as $uom1)
                                                        <option value="{{ $uom1['id'] }}">{{ $uom1['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" style="text-align:right" step="0.01"
                                                class="form-select form-select-sm focusable"
                                                wire:model.lazy="invoiceItems.{{ $index }}.max_retail_price">
                                        </td>
                                        <td>
                                            <input type="number" style="text-align:right" step="0.01"
                                                placeholder="Price" class="form-select form-select-sm focusable"
                                                wire:model.lazy="invoiceItems.{{ $index }}.price">
                                        </td>
                                        <td>
                                            <input type="number" style="text-align:right" step="0.01"
                                                placeholder="Dis%" class="form-select form-select-sm focusable"
                                                wire:model.lazy="invoiceItems.{{ $index }}.discount_pct">
                                        </td>
                                        <td class="item-id-input">
                                            <input type="number" style="text-align:right" step="0.01"
                                                placeholder="DisAmt"
                                                class="form-select form-select-sm item-id-input focusable"
                                                wire:model.lazy="invoiceItems.{{ $index }}.discount_amt">
                                        </td>
                                        <td class="item-id-input">
                                            <input type="text" style="text-align:right" class="item-id-input"
                                                placeholder="GST%"
                                                wire:model.lazy="invoiceItems.{{ $index }}.gst_percent"
                                                disabled readonly>
                                        </td>
                                        <td>
                                            <input type="number" style="text-align:right" step="0.01"
                                                placeholder="Amount"
                                                class="form-select form-select-sm focusable amount-input"
                                                id="amount_{{ $index }}"
                                                wire:model.lazy="invoiceItems.{{ $index }}.item_amount">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-btn"
                                                wire:click="removeItemRow({{ $index }})">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                            <input type="text" class="item-id-input"
                                                wire:model.lazy="invoiceItems.{{ $index }}.tax_category_id">
                                            <input type="text" class="item-id-input"
                                                wire:model.lazy="invoiceItems.{{ $index }}.hsn_sac">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <td class="m-0 border-0">
                                    <div class="m-0 border-0">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            wire:click="addItemRow">Add Item</button>
                                    </div>
                                </td>
                                <th colspan="9">Sub Total</th>
                                <th style="width: 10%; text-align: end;font-weight:bold; font-size:.9rem;">
                                    {{ Number::currency($itemSubTotal, 'INR') }}</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                    </table>

                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            @if ($this->current_stock)
                                <small class="text-sm text-danger">(Cur. Stock = {{ $this->current_stock }}
                                    {{ $this->current_uom }})</small>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="table-responsive scrollable-table">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Bill Sundry</th>
                                            <th style="width: 20%">Amount (Rs.)</th>
                                            <th style="width: 5%;">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sundries as $index => $sundry)
                                            <tr wire:key="sundry-{{ $index }}">
                                                <td>
                                                    <input type="text" readonly class="form-select form-select-sm"
                                                        wire:model="sundries.{{ $index }}.amount_adjustment"
                                                        placeholder="Type">
                                                </td>
                                                <td>
                                                    <select id="sundry-{{ $index }}-select"
                                                        wire:model.lazy="sundries.{{ $index }}.bill_sundry_id"
                                                        class="form-select form-select-sm">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($allBillSundries as $bs)
                                                            <option value="{{ $bs->id }}">
                                                                ({{ $bs->adjustment == '+' ? 'Add' : 'Less' }})
                                                                {{ $bs->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" style="text-align:right"
                                                        placeholder="Amount"
                                                        id="sundry-{{ $index }}-sundry_amount" step="0.01"
                                                        class="form-select form-select-sm"
                                                        wire:model.lazy="sundries.{{ $index }}.sundry_amount">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-btn"
                                                        wire:click="removeSundry({{ $index }})">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th class="border-0">
                                                <button type="button" class="btn btn-primary btn-sm m-2"
                                                    wire:click="addSundry">Add BillSundry</button>
                                            </th>
                                            <th>Bill Sundry Sub Total</th>
                                            <th style="text-align: end;font-weight:bold; font-size:.9rem;">
                                                {{ Number::currency($sundrySubTotal, 'INR') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th colspan="2">Grand Total</th>
                                            <th
                                                style="width: 10%; text-align: end;font-weight:bold; font-size:1.2rem;">
                                                {{ Number::currency($sundrySubTotal + $itemSubTotal, 'INR') }}</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm m-3">
                                {{ $invoice->id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="title-breadcrumb">
                    <h3>{{ $breadcrumb_header ?? 'Select from menu' }}</h3>
                </div>
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
        </div>

    </form>
    @if ($invoice->id)
        <form wire:submit="printInvoice">
            <select wire:model="printFormats">
                @foreach ($printFormats as $printFormat)
                    <option value="{{ $printFormat['id'] }}">{{ $printFormat['name'] }}</option>
                @endforeach
            </select>
            <button type="submit">Print</button>
        </form>
    @endif
</div>
@push('scripts')
    <script>
        (function() {
            if (window.invoiceFormScriptInitialized) {
                return;
            }
            window.invoiceFormScriptInitialized = true;

            let listenerBound = false;

            function bindAutocomplete($elements) {
                if (typeof $.fn.autocomplete === 'undefined') {
                    console.error('jQuery UI Autocomplete is not loaded');
                    return;
                }
                $elements.each(function() {
                    const $input = $(this);
                    if ($input.hasClass('autocomplete-bound')) return;
                    const index = $input.data('index');
                    $input.addClass('autocomplete-bound');
                    $input.autocomplete({
                        source: function(request, response) {
                            $.get("{{ route('autocomplete.items') }}", {
                                    term: request.term,
                                    invoice_type_id: '{{ $invoiceData['invoice_type_id'] }}'
                                })
                                .done(function(data) {
                                    response(data);
                                })
                                .fail(function(jqXHR, textStatus, errorThrown) {
                                    response([]);
                                });
                        },
                        minLength: 0, // Set minLength to 0 to allow empty search
                        select: function(event, ui) {
                            const $textInput = $(`#item_id_${index}`);
                            const $quantityInput = $(`#quantity_${index}`);
                            setTimeout(() => {
                                $textInput.val(ui.item.value);
                                const inputEvent = new Event('input', {
                                    bubbles: true
                                });
                                $textInput[0].dispatchEvent(inputEvent);
                                Livewire.dispatchTo('transaction.invoice-form',
                                    'update', {
                                        name: `invoiceItems.${index}.item_id`,
                                        value: ui.item.value
                                    });
                                $quantityInput.focus();
                            }, 50);
                            $input.val(ui.item.label);
                            return false;
                        },
                        focus: function(event, ui) {
                            // Prevent the input value from changing on focus
                            return false;
                        }
                    }).on('focus', function() {
                        // Trigger search on focus to show all options
                        $(this).autocomplete('search', '');
                    });
                });
            }

            function handleEnterKey(e) {
                if (e.key === 'Enter' && e.target.classList.contains('focusable')) {
                    e.preventDefault();
                    const input = e.target;
                    if (input.classList.contains('amount-input')) {
                        const confirmAdd = window.confirm('Add another item?');
                        if (confirmAdd) {
                            try {
                                const component = Livewire.find(document.querySelector('[wire\\:id]').getAttribute(
                                    'wire:id'));
                                if (component) {
                                    component.call('addItemRow');
                                } else {
                                    console.error('Livewire component not found');
                                }
                                Livewire.dispatchTo('transaction.invoice-form', 'addItemRow');
                            } catch (error) {
                                console.error('Failed to dispatch addItemRow:', error);
                            }
                        }
                    } else {
                        const focusableInputs = document.querySelectorAll('.focusable');
                        const currentIndex = Array.from(focusableInputs).indexOf(input);
                        const nextIndex = currentIndex + 1;
                        if (nextIndex < focusableInputs.length) {
                            const nextInput = focusableInputs[nextIndex];
                            nextInput.focus();
                        }
                    }
                }
            }

            function initializeUIEnhancements() {
                bindAutocomplete($('.item-autocomplete:not(.autocomplete-bound)'));
                initializeEnterKeyNavigation();
            }
            ['DOMContentLoaded', 'livewire:updated', 'livewire:navigated'].forEach(event => {
                document.addEventListener(event, initializeUIEnhancements);
            });

            window.addEventListener('item-row-added', () => {
                setTimeout(() => {
                    const $newInputs = $('.item-autocomplete:not(.autocomplete-bound)');
                    if ($newInputs.length > 0) {
                        bindAutocomplete($newInputs);
                        const newIndex = $newInputs.first().data('index');
                        const $newAutocomplete = $(`#item_name_${newIndex}`);
                        $newAutocomplete.focus();
                    }
                }, 100);
            });


            window.addEventListener('confirm-material-center-change', () => {
                if (!confirm('Changing the Store will update all invoice items. Continue?')) {
                    const originalMcId = '{{ old('mc_id', $invoice->store_id) }}';
                    Livewire.dispatchTo('transaction.invoice-form', 'set', {
                        name: 'mc_id',
                        value: originalMcId
                    });
                }
            });
        })();
    </script>
@endpush
