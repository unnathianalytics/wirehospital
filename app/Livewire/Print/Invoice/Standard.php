<?php

namespace App\Livewire\Print\Invoice;

use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoicePrintConfig;
use Livewire\Component;

class Standard extends Component
{
    public $invoice;
    public $format;

    public $itemsAmount = 0;
    public float $sundriesAmount = 0;
    public float $invoiceAmount = 0;

    public function mount($invoiceId, $formatId)
    {
        $this->invoice = Invoice::with('items', 'items.serial_numbers', 'invoiceType', 'invoiceSundries', 'account')->find($invoiceId);
        $this->format = InvoicePrintConfig::findOrFail($formatId);
        $this->sundriesAmount = $this->invoice->invoiceSundryTotal();
        $this->itemsAmount = $this->invoice->invoiceItemTotal();
        $this->invoiceAmount = $this->invoice->getInvoiceTotal();
    }
    public function render()
    {
        return view('livewire.print.invoice.standard', [
            'invoice' => $this->invoice,
            'format' => $this->format
        ]);
    }
}
