<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Account, BillSundry, TaxType, Item, Invoice, VoucherSeries, ItemUom, Uom, InvoiceSundry, InvoiceType,  InvoiceItem,  Store, InvoicePrintConfig};

class InvoiceForm extends Component
{
    public $breadcrumb_header;
    public string $invoiceType = '';
    public string $bg_color = '#FFFFFF';
    public array $invoiceData = [];
    public $financial_year_id, $invoice_number, $invoice_date, $voucher_series_id, $mc_id, $tax_type_id, $invoice_time, $account_id, $description;
    public $countable, $stock_update_date, $item_id, $item_description1, $item_description2, $item_description3, $item_description4, $uom_id, $quantity, $base_quantity, $hsn_sac, $batch_no, $batch_exp, $max_retail_price, $price, $tax_category_id, $igst_pct, $cgst_pct, $sgst_pct, $cess_pct, $igst_amt, $cgst_amt, $sgst_amt, $cess_amt, $discount_pct, $discount_amt, $taxable_amt, $item_amount;

    public $allMCs;
    public $current_stock = 0;
    public string $current_balance = '0';
    public $current_uom;
    public $voucherSeries;
    public $accounts = [];
    public $allItems;
    public array $invoiceItems = [];
    public $itemSubTotal = 0;
    public $sundrySubTotal = 0;
    public $taxTypes = [];
    public $uoms;
    public $itemUoms;
    public array $itemUomOptions = [];
    public $sundries;
    public $allBillSundries;
    protected $itemUomsByItemUomId;
    protected $allItemsById;
    public Invoice $invoice;
    public string $lastEditedField = '';
    public int|null $lastEditedIndex = null;
    public $invoiceTotalAmount = 0;
    public $currentItemIndex = null;
    public $selectAll = false;
    public $usedSnIds = [];
    public $defaultItemValues = [
        'current_stock' => 0,
        'item_id' => null,
        'item_name' => '',
        'item_description1' => '',
        'item_description2' => '',
        'item_description3' => '',
        'item_description4' => '',
        'uom_id' => null,
        'quantity' => null,
        'base_quantity' => null,
        'hsn_sac' => null,
        'batch_no' => '',
        'batch_exp' => null,
        'max_retail_price' => 0.00,
        'price' => 0.00,
        'tax_category_id' => null,
        'igst_pct' => 0.00,
        'cgst_pct' => 0.00,
        'sgst_pct' => 0.00,
        'cess_pct' => 0.00,
        'igst_amt' => 0.00,
        'cgst_amt' => 0.00,
        'sgst_amt' => 0.00,
        'cess_amt' => 0.00,
        'discount_pct' => 0.00,
        'discount_amt' => 0.00,
        'taxable_amt' => 0.00,
        'item_amount' => 0.00,
        'countable' => true,
        'stock_update_date' => null,
        'store_id' => null,
        'is_new' => true,
    ];
    public $printFormats;
    public $printConfigId;

    public function placeholder()
    {
        return <<<'HTML'
        <div class="container-fluid">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150"><path fill="none" stroke="#FF156D" stroke-width="15" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z"><animate attributeName="stroke-dashoffset" calcMode="spline" dur="2" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate></path></svg>
        </div>
        HTML;
    }

    public function mount(string $invoiceType, ?int $invoiceId = null)
    {
        $invoiceTypeModel = InvoiceType::where('slug', $invoiceType)->firstOrFail();
        $this->invoiceType = $invoiceTypeModel->slug;
        $this->bg_color = $invoiceTypeModel->bg_color ?? '#FFFFFF';
        $this->voucherSeries = VoucherSeries::where('invoice_type_id', $invoiceTypeModel->id)->get();
        $this->accounts = Account::invoiceAccounts()->get();
        $this->allItems = Item::all();
        $this->allMCs = Store::all();
        $this->taxTypes = TaxType::all();
        $this->uoms = Uom::all();
        $this->itemUoms = ItemUom::all();
        $this->allBillSundries = BillSundry::all();
        $this->invoice = $invoiceId
            ? $this->loadInvoiceModel($invoiceId)
            : $this->newInvoiceModel($invoiceTypeModel->id);

        $this->mc_id = $this->invoice->store_id;

        $this->invoiceData = [
            'voucher_series_id' => $this->invoice->voucher_series_id ?? null,
            'invoice_date' => $invoiceId ? Carbon::parse($this->invoice->invoice_date)->format('d-m-Y') : now()->format('d-m-Y'),
            'invoice_number' => $this->invoice->invoice_number ?? '',
            'invoice_time' => $this->invoice->invoice_time ?? now()->format('H:i'),
            'tax_type_id' => $this->invoice->tax_type_id ?? null,
            'account_id' => $this->invoice->account_id ?? null,
            'description' => $this->invoice->description ?? '',
            'invoice_type_id' => $this->invoice->invoice_type_id ?? $invoiceTypeModel->id,
        ];

        $this->invoiceItems = [];
        foreach ($this->invoice->items as $item) {
            $this->invoiceItems[] = array_merge($this->defaultItemValues, [
                'item_id' => $item->item_id,
                'item_name' => $item->item?->name ?? '',
                'item_description1' => $item->item_description1,
                'item_description2' => $item->item_description2,
                'item_description3' => $item->item_description3,
                'item_description4' => $item->item_description4,
                'uom_id' => $item->uom_id,
                'quantity' => $item->quantity,
                'base_quantity' => $item->base_quantity,
                'hsn_sac' => $item->hsn_sac,
                'batch_no' => $item->batch_no,
                'batch_exp' => $item->batch_exp,
                'max_retail_price' => $item->max_retail_price,
                'price' => $item->price,
                'tax_category_id' => $item->tax_category_id,
                'igst_pct' => $item->igst_pct,
                'cgst_pct' => $item->cgst_pct,
                'sgst_pct' => $item->sgst_pct,
                'cess_pct' => $item->cess_pct,
                'igst_amt' => $item->igst_amt,
                'cgst_amt' => $item->cgst_amt,
                'sgst_amt' => $item->sgst_amt,
                'cess_amt' => $item->cess_amt,
                'discount_pct' => $item->discount_pct,
                'discount_amt' => $item->discount_amt,
                'taxable_amt' => $item->taxable_amt,
                'item_amount' => $item->item_amount,
                'countable' => $item->countable,
                'stock_update_date' => $item->stock_update_date,
                'store_id' => $item->store_id,
                'is_new' => false,
            ]);
            if ($invoiceId) {
                $this->printFormats = InvoicePrintConfig::where('invoice_type_id', $invoiceTypeModel->id)->get();
            }
        }

        foreach ($this->invoiceItems as $index => $item) {
            $this->fillItemDefaults($index);
        }

        $this->itemSubTotal = collect($this->invoiceItems)->sum('item_amount');

        if (empty($this->invoiceItems)) {
            $this->invoiceItems[] = $this->defaultItemValues;
        }

        if ($invoiceId) {
            $this->invoice = Invoice::with(['invoiceSundries', 'items'])->findOrFail($invoiceId)->fresh();
            $this->sundries = collect();
            foreach ($this->invoice->invoiceSundries as $sundry) {
                $this->sundries->push([
                    'amount_adjustment' => $sundry->billSundry->adjustment,
                    'bill_sundry_id' => $sundry->bill_sundry_id,
                    'sundry_amount' => $sundry->sundry_amount,
                ]);
                $this->sundrySubTotal += ($sundry->billSundry->adjustment === '-' ? -1 : 1) * $sundry->sundry_amount;
            }
        } else {
            $this->invoice = new Invoice(['invoice_type_id' => $invoiceTypeModel->id]);
            $this->sundries = collect([]);
        }

        $this->breadcrumb_header = ucwords($invoiceTypeModel->name);

        if (!$invoiceId && !empty($this->invoiceData['voucher_series_id'])) {
            $this->invoiceData['invoice_number'] = Invoice::generateInvoiceNumber(
                $this->invoiceData['voucher_series_id'],
                $this->invoiceData['invoice_type_id'],
                $this->invoiceData['invoice_date']
            );
        }
    }

    protected function loadInvoiceModel(int $id): Invoice
    {
        return Invoice::with(['items.store', 'invoiceSundries'])->findOrFail($id)->fresh();
    }

    protected function newInvoiceModel(int $invoiceTypeId): Invoice
    {
        return new Invoice(['invoice_type_id' => $invoiceTypeId]);
    }

    public function updatedInvoiceData($value, $key)
    {
        if ($key === 'voucher_series_id' && $value) {
            $this->invoiceData['invoice_number'] = Invoice::generateInvoiceNumber(
                $this->invoiceData['voucher_series_id'],
                $this->invoiceData['invoice_type_id'],
                $this->invoiceData['invoice_date']
            );
        } elseif ($key === 'voucher_series_id' && !$value) {
            $this->invoiceData['invoice_number'] = '';
        } elseif ($key === 'account_id') {
            $account = Account::find($value);
            $this->current_balance = $account ? $account->get_cb($this->invoiceData['invoice_date'], false) : 0;
        }
    }

    public function addItemRow()
    {
        $this->invoiceItems[] = array_merge($this->defaultItemValues, [
            'store_id' => $this->mc_id,
            'is_new' => true,
        ]);
        $this->current_stock = null;
        $this->dispatch('item-row-added');
    }

    public function removeItemRow($index)
    {
        unset($this->invoiceItems[$index]);
        $this->invoiceItems = array_values($this->invoiceItems);
        $this->recalculateItemAmounts();
        $this->recalculateSundryAmount();
    }

    public function addSundry()
    {
        $this->sundries[] = [
            'amount_adjustment' => '',
            'bill_sundry_id' => '',
            'sundry_amount' => 0,
        ];
    }

    public function removeSundry($index)
    {
        $this->sundries->forget($index);
        $this->sundries = $this->sundries->values();
        $this->recalculateSundryAmount();
    }


    public function updatedMcId($value)
    {
        if ($this->invoice->exists) {
            $this->dispatch('confirm-material-center-change');
        }
        foreach ($this->invoiceItems as $index => $item) {
            $this->invoiceItems[$index]['store_id'] = $value;
        }
    }

    protected function fillItemDefaults(int $index): void
    {
        $itemId = $this->invoiceItems[$index]['item_id'] ?? null;
        if (!$itemId) {
            $this->itemUomOptions[$index] = [];
            return;
        }
        $item = $this->allItems->firstWhere('id', $itemId);
        if (!$item) {
            $this->itemUomOptions[$index] = [];
            return;
        }
        $this->invoiceItems[$index]['item_name'] = $item->name;

        if (!isset($this->invoiceItems[$index]['price']) || !$this->invoiceItems[$index]['price']) {
            $this->invoiceItems[$index]['price'] = $this->invoiceType == 'purchase' ? $item->purchase_price : $item->sale_price;
        }

        if ($this->invoice->exists && !$this->invoiceItems[$index]['is_new']) {
            $this->invoiceItems[$index]['max_retail_price'] = $this->invoiceItems[$index]['max_retail_price'] ?? 0.00;
            $this->invoiceItems[$index]['hsn_sac'] = $this->invoiceItems[$index]['hsn_sac'] ?? null;
        } else {
            $this->invoiceItems[$index]['max_retail_price'] = $item->max_retail_price ?? 0.00;
            $this->invoiceItems[$index]['hsn_sac'] = $item->hsn_sac;
        }

        $this->invoiceItems[$index]['tax_category_id'] = $item->tax_category_id;
        $this->current_stock = $item->getStock();
        if ($item->taxcategory) {
            $this->invoiceItems[$index]['igst_pct'] = $item->taxcategory->igst_pct ?? 0.00;
            $this->invoiceItems[$index]['cgst_pct'] = $item->taxcategory->cgst_pct ?? 0.00;
            $this->invoiceItems[$index]['sgst_pct'] = $item->taxcategory->sgst_pct ?? 0.00;
            $this->invoiceItems[$index]['cess_pct'] = $item->taxcategory->cess_pct ?? 0.00;
            $this->invoiceItems[$index]['gst_percent'] = sprintf(
                '%s+%s+%s',
                $item->taxcategory->cgst_pct ?? 0,
                $item->taxcategory->sgst_pct ?? 0,
                $item->taxcategory->cess_pct ?? 0
            );
        } else {
            $this->invoiceItems[$index]['igst_pct'] = 0.00;
            $this->invoiceItems[$index]['cgst_pct'] = 0.00;
            $this->invoiceItems[$index]['sgst_pct'] = 0.00;
            $this->invoiceItems[$index]['cess_pct'] = 0.00;
            $this->invoiceItems[$index]['gst_percent'] = '0+0+0';
        }

        $this->invoiceItems[$index]['taxable_amt'] = $item->taxable_amt ?? 0.00;

        if (!isset($this->invoiceItems[$index]['uom_id']) || !$this->invoiceItems[$index]['uom_id']) {
            $this->invoiceItems[$index]['uom_id'] = $item->uom_id;
        }

        $uomsById = $this->uoms->keyBy('id');
        $itemUomIds = $this->itemUoms
            ->where('item_id', $itemId)
            ->pluck('uom_id')
            ->unique()
            ->prepend($item->uom_id)
            ->unique();

        $uoms = $itemUomIds
            ->map(fn($id) => isset($uomsById[$id])
                ? ['id' => $id, 'name' => $uomsById[$id]->name]
                : null)
            ->filter()
            ->values()
            ->all();
        $this->itemUomOptions[$index] = $uoms;
        $this->current_uom = $item->baseUom->name ?? null;
    }

    public function updatedInvoiceItems($value, $key)
    {
        if (preg_match('/^(\d+)\.(price|item_amount)$/', $key, $matches)) {
            $this->lastEditedIndex = (int) $matches[1];
            $this->lastEditedField = $matches[2];
        }
        if (preg_match('/^(\d+)\.item_id$/', $key, $matches)) {
            $index = (int) $matches[1];
            $this->fillItemDefaults($index);
            $this->recalculateItemAmounts();
        }
        if (preg_match('/^(\d+)\.quantity$/', $key, $matches)) {
            $index = (int) $matches[1];
        }
        $this->recalculateItemAmounts();
    }

    public function updatedSundries($value, $key)
    {
        if (str_ends_with($key, 'bill_sundry_id')) {
            [$index, $field] = explode('.', $key);
            $selectedId = $this->sundries[$index]['bill_sundry_id'] ?? null;

            if ($selectedId) {
                $bs = $this->allBillSundries->firstWhere('id', $selectedId);
                $this->sundries = collect($this->sundries)
                    ->map(function ($sundry, $i) use ($index, $bs) {
                        if ($i == $index) {
                            $sundry['amount_adjustment'] = $bs?->adjustment ?? '';
                        }
                        return $sundry;
                    })
                    ->toArray();
            }
        }
        $this->recalculateSundryAmount();
    }


    public function recalculateSundryAmount()
    {
        $this->sundrySubTotal = 0;
        foreach ($this->sundries as $s) {
            $tempAmount = (float) ($s['sundry_amount'] ?? 0);
            $adjustment = $s['amount_adjustment'] === '-' ? -1 : 1;
            $this->sundrySubTotal += $adjustment * $tempAmount;
        }
    }

    public function recalculateItemAmounts()
    {
        foreach ($this->invoiceItems as $i => $item) {
            $qty = floatval($item['quantity'] ?? 0);
            $price = floatval($item['price'] ?? 0);
            $discount_pct = floatval($item['discount_pct'] ?? 0);
            $discount_amt = floatval($item['discount_amt'] ?? 0);
            $cgst_pct = floatval($item['cgst_pct'] ?? 0);
            $sgst_pct = floatval($item['sgst_pct'] ?? 0);
            $cess_pct = floatval($item['cess_pct'] ?? 0);
            $total_gst_pct = $cgst_pct + $sgst_pct + $cess_pct;

            $item_amount = floatval($item['item_amount'] ?? 0);
            $discount_per_unit = 0;
            $cgst_amt = 0;
            $sgst_amt = 0;
            $cess_amt = 0;
            $taxable_amt = 0;
            $final_item_amount = 0;

            if (
                $this->lastEditedIndex === $i &&
                $this->lastEditedField === 'item_amount' &&
                $qty > 0
            ) {
                $taxable_amt = $item_amount / (1 + $total_gst_pct / 100);
                $subtotal = $taxable_amt / (1 - ($discount_pct / 100));
                $price = $qty > 0 ? $subtotal / $qty : 0;

                $discount_amt = $subtotal - $taxable_amt;
                $discount_per_unit = $qty > 0 ? $discount_amt / $qty : 0;

                $cgst_amt = ($taxable_amt * $cgst_pct) / 100;
                $sgst_amt = ($taxable_amt * $sgst_pct) / 100;
                $cess_amt = ($taxable_amt * $cess_pct) / 100;

                $final_item_amount = $taxable_amt + $cgst_amt + $sgst_amt + $cess_amt;
            } elseif (
                $this->lastEditedIndex === $i &&
                $this->lastEditedField === 'discount_amt' &&
                $qty > 0
            ) {
                $subtotal = $qty * $price;
                $discount_pct = $subtotal > 0 ? ($discount_amt / $subtotal) * 100 : 0;
                $discount_per_unit = $qty > 0 ? $discount_amt / $qty : 0;
                $taxable_amt = $subtotal - $discount_amt;

                $cgst_amt = ($taxable_amt * $cgst_pct) / 100;
                $sgst_amt = ($taxable_amt * $sgst_pct) / 100;
                $cess_amt = ($taxable_amt * $cess_pct) / 100;

                $final_item_amount = $taxable_amt + $cgst_amt + $sgst_amt + $cess_amt;
            } else {
                $subtotal = $qty * $price;
                $discount_amt = ($subtotal * $discount_pct) / 100;
                $discount_per_unit = $qty > 0 ? $discount_amt / $qty : 0;
                $taxable_amt = $subtotal - $discount_amt;

                $cgst_amt = ($taxable_amt * $cgst_pct) / 100;
                $sgst_amt = ($taxable_amt * $sgst_pct) / 100;
                $cess_amt = ($taxable_amt * $cess_pct) / 100;

                $final_item_amount = $taxable_amt + $cgst_amt + $sgst_amt + $cess_amt;
            }

            $this->invoiceItems[$i]['price'] = round($price, 2);
            $this->invoiceItems[$i]['discount_amt'] = round($discount_amt, 2);
            $this->invoiceItems[$i]['discount_pct'] = round($discount_pct, 2);
            $this->invoiceItems[$i]['discount_per_unit'] = round($discount_per_unit, 2);
            $this->invoiceItems[$i]['cgst_amt'] = round($cgst_amt, 2);
            $this->invoiceItems[$i]['sgst_amt'] = round($sgst_amt, 2);
            $this->invoiceItems[$i]['cess_amt'] = round($cess_amt, 2);
            $this->invoiceItems[$i]['taxable_amt'] = round($taxable_amt, 2);
            $this->invoiceItems[$i]['item_amount'] = round($final_item_amount, 2);
        }

        $this->itemSubTotal = collect($this->invoiceItems)->sum('item_amount');
        $this->lastEditedIndex = null;
        $this->lastEditedField = '';
    }

    protected function getUomConversionFactor(int $itemId, int $uomId): float
    {
        if (blank($this->allItems) || blank($this->itemUoms)) {
            return 1.0;
        }
        $this->allItemsById ??= $this->allItems->keyBy('id');
        $this->itemUomsByItemUomId ??= $this->itemUoms
            ->groupBy(fn($row) => $row->item_id . ':' . $row->uom_id);
        $item = $this->allItemsById[$itemId] ?? null;
        if ($item?->uom_id == $uomId) {
            return 1.0;
        }
        $conversion = $this->itemUomsByItemUomId[$itemId . ':' . $uomId][0] ?? null;
        return (float) ($conversion->conversion_factor ?? 1.0);
    }



    public function save()
    {
        $dates = getUserFinancialYearDates();
        if ($this->invoice->exists && current_user()->financial_year_id != $this->invoice->financial_year_id) {
            $this->addError('financial_year', 'You cannot edit invoices from a different financial year.');
            return;
        }
        $fromDate = $dates['from_date'];
        $toDate = $dates['to_date'];

        $invoiceType = InvoiceType::findOrFail($this->invoiceData['invoice_type_id']);
        $rules = [
            'invoiceData.voucher_series_id' => 'required',
            'invoiceData.invoice_date' => "required|date|date_format:d-m-Y|after_or_equal:{$fromDate}|before_or_equal:{$toDate}",
            'invoiceData.invoice_number' => 'required|string|min:1',
            'invoiceData.tax_type_id' => 'required',
            'invoiceData.account_id' => 'required',
            'invoiceData.description' => 'nullable|string|max:255',
            'invoiceData.invoice_type_id' => 'required|exists:invoice_types,id',
            'mc_id' => 'required|exists:stores,id',
            'invoiceItems' => 'required|array|min:1',
            'invoiceItems.*.item_id' => [
                'required',
                'exists:items,id',
                function ($attribute, $value, $fail) {
                    $invoiceType = InvoiceType::find($this->invoiceData['invoice_type_id']);
                    if ($invoiceType->in_out === 'inward' && $invoiceType->transaction_category === 'return' && !$this->invoice->exists) {
                        $allowedTypeId = $invoiceType->allowed_return_from;
                        $itemInvoices = InvoiceItem::where('item_id', $value)
                            ->whereHas('invoice', fn($query) => $query->where('invoice_type_id', $allowedTypeId))
                            ->exists();
                        if (!$itemInvoices) {
                            $fail("Item must originate from an invoice of type ID {$allowedTypeId}.");
                        }
                    }
                },
            ],
            'invoiceItems.*.store_id' => 'nullable|exists:stores,id',
            'invoiceItems.*.item_description1' => 'nullable|string|max:255',
            'invoiceItems.*.item_description2' => 'nullable|string|max:255',
            'invoiceItems.*.item_description3' => 'nullable|string|max:255',
            'invoiceItems.*.item_description4' => 'nullable|string|max:255',
            'invoiceItems.*.hsn_sac' => 'string|max:8',
            'invoiceItems.*.uom_id' => 'required',
            'invoiceItems.*.quantity' => 'required|numeric|min:0.01',
            'invoiceItems.*.base_quantity' => 'nullable',
            'invoiceItems.*.batch_no' => 'nullable|string|max:50',
            'invoiceItems.*.batch_exp' => 'nullable|date',
            'invoiceItems.*.max_retail_price' => 'nullable|numeric|min:0',
            'invoiceItems.*.tax_category_id' => 'required',
            'invoiceItems.*.price' => 'required|numeric|min:0',
            'invoiceItems.*.discount_pct' => 'nullable|numeric|min:0|max:100',
            'invoiceItems.*.discount_amt' => 'nullable|numeric|min:0',
            'invoiceItems.*.item_amount' => 'required|numeric|min:0',
            'sundries.*.bill_sundry_id' => 'required|exists:bill_sundries,id',
            'sundries.*.sundry_amount' => 'required|numeric|min:0',
        ];

        if ($invoiceType->sn_input_type !== 'none') {
            foreach ($this->invoiceItems as $index => $item) {
            }

            $this->validate($rules, [
                'invoiceData.voucher_series_id.required' => 'Invoice series is required.',
                'invoiceData.invoice_date.required' => 'Invoice date is required.',
                'invoiceData.invoice_date.before_or_equal' => 'Date not within financial year.',
                'invoiceData.invoice_date.after_or_equal' => 'Date belongs to old financial year.',
                'invoiceData.invoice_number.required' => 'Invoice number cannot be empty.',
                'invoiceData.invoice_number.min' => 'Invoice number cannot be empty.',
                'invoiceData.invoice_type_id.required' => 'Invoice type is required.',
                'invoiceData.account_id.required' => 'Party account is required.',
                'mc_id.required' => 'Store is required.',
                'invoiceData.description.string' => 'Description must be a string.',
                'invoiceItems.required' => 'At least one invoice item is required.',
                'invoiceItems.*.item_id.required' => 'Item is required for row :index.',
                'invoiceItems.*.item_id.integer' => 'Select a valid item for row :index.',
                'invoiceItems.*.quantity.required' => 'Quantity is required for row :index.',
                'invoiceItems.*.quantity.numeric' => 'Quantity must be a number for row :index.',
                'invoiceItems.*.max_retail_price.numeric' => 'Max retail price must be a number for row :index.',
                'invoiceItems.*.hsn_sac.string' => 'HSN/SAC should be 2|4|6|8 digits for row :index.',
                'invoiceItems.*.price.required' => 'Price is required for row :index.',
                'invoiceItems.*.price.numeric' => 'Price must be a number for row :index.',
                'invoiceItems.*.discount_pct.numeric' => 'Discount percentage must be a number for row :index.',
                'invoiceItems.*.discount_pct.min' => 'Discount percentage must be at least 0 for row :index.',
                'invoiceItems.*.discount_pct.max' => 'Discount percentage cannot exceed 100 for row :index.',
                'invoiceItems.*.discount_amt.numeric' => 'Discount amount must be a number for row :index.',
                'invoiceItems.*.item_amount.required' => 'Amount is required for row :index.',
                'invoiceItems.*.item_amount.numeric' => 'Amount must be a number for row :index.',
                'invoiceItems.*.item_amount.min' => 'Amount must be at least 0 for row :index.',

            ]);

            foreach ($this->invoiceItems as &$item) { // { Foreach 2
                $item['is_new'] = false;
            } // } Foreach 2

            if (empty($this->invoiceData['invoice_number'])) { // { If 10
                $this->addError('invoiceData.invoice_number', 'Invoice number cannot be empty.');
                return;
            } // } If 10

            $this->invoice->financial_year_id = current_user()->financial_year_id;
            $this->invoice->invoice_type_id = $this->invoiceData['invoice_type_id'];
            $this->invoice->voucher_series_id = $this->invoiceData['voucher_series_id'];
            $this->invoice->invoice_date = Carbon::createFromFormat('d-m-Y', $this->invoiceData['invoice_date'])->format('Y-m-d');
            $this->invoice->invoice_time = now()->format('H:i');
            $this->invoice->tax_type_id = $this->invoiceData['tax_type_id'];
            $this->invoice->account_id = $this->invoiceData['account_id'];
            $this->invoice->description = $this->invoiceData['description'];
            $this->invoice->invoice_number = $this->invoiceData['invoice_number'];
            $this->invoice->store_id = $this->mc_id;
            $this->invoice->save();

            $this->invoice->items()->delete();
            $this->invoice->invoiceSundries()->delete();

            foreach ($this->invoiceItems as $index => $itemData) { // { Foreach 3
                $selectedUomId = $itemData['uom_id'];
                $qty = $itemData['quantity'];
                $conversion = $this->getUomConversionFactor($itemData['item_id'], $selectedUomId);
                $baseQty = $qty * $conversion;

                $invoiceItem = $this->invoice->items()->create([
                    'item_id' => $itemData['item_id'],
                    'store_id' => $this->mc_id,
                    'item_description1' => $itemData['item_description1'],
                    'item_description2' => $itemData['item_description2'],
                    'item_description3' => $itemData['item_description3'],
                    'item_description4' => $itemData['item_description4'],
                    'uom_id' => $selectedUomId,
                    'quantity' => $qty,
                    'base_quantity' => $baseQty,
                    'hsn_sac' => $itemData['hsn_sac'],
                    'batch_no' => $itemData['batch_no'],
                    'batch_exp' => $itemData['batch_exp'],
                    'max_retail_price' => $itemData['max_retail_price'],
                    'price' => $itemData['price'],
                    'tax_category_id' => $itemData['tax_category_id'],
                    'igst_pct' => $itemData['igst_pct'],
                    'cgst_pct' => $itemData['cgst_pct'],
                    'sgst_pct' => $itemData['sgst_pct'],
                    'cess_pct' => $itemData['cess_pct'],
                    'igst_amt' => $itemData['igst_amt'],
                    'cgst_amt' => $itemData['cgst_amt'],
                    'sgst_amt' => $itemData['sgst_amt'],
                    'cess_amt' => $itemData['cess_amt'],
                    'discount_pct' => $itemData['discount_pct'],
                    'discount_amt' => $itemData['discount_amt'],
                    'taxable_amt' => $itemData['taxable_amt'],
                    'item_amount' => $itemData['item_amount'],
                    'countable' => $itemData['countable'],
                    'stock_update_date' => now(),
                ]);
            } // } Foreach 3

            foreach ($this->sundries as $sundry) { // { Foreach 5
                InvoiceSundry::create([
                    'invoice_id' => $this->invoice->id,
                    'amount_adjustment' => $sundry['amount_adjustment'],
                    'bill_sundry_id' => $sundry['bill_sundry_id'],
                    'sundry_amount' => $sundry['sundry_amount'],
                ]);
            } // } Foreach 5

            $this->invoice->load('items', 'invoiceSundries');
            $invoiceTypeSlug = InvoiceType::findOrFail($this->invoice->invoice_type_id)->slug;
            return redirect(route('invoice_index', ['invoiceType' => $invoiceTypeSlug])); // Method end
        }
    }

    public function render()
    {
        return view('livewire.transaction.invoice-form', [
            'invoiceTypeModel' => InvoiceType::findOrFail($this->invoiceData['invoice_type_id']),
        ]);
    }

    public function printInvoice()
    {
        $format = $this->printFormats->first()->id;
        $parameters = ['invoiceType' => $this->invoice->invoiceType->slug, 'invoiceId' => $this->invoice->id, 'format' => $format];
        return redirect(route('invoice_standard', $parameters));
    }
}
