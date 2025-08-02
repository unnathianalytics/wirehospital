<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceType;

class InvoiceIndex extends Component
{
    public $fromDate;
    public $toDate;
    public $showItems;
    public $invoice_type_id;
    public $financialDates;
    public function mount()
    {
        $this->financialDates = getUserFinancialYearDates();
        //$today = now()->format('Y-m-d');
        $this->fromDate = $this->financialDates['from_date'];
        $this->toDate = $this->financialDates['to_date'];
        $this->showItems = 'no';
    }

    public function render()
    {
        if ($this->fromDate < $this->financialDates['from_date']) $this->fromDate = $this->financialDates['from_date'];
        if ($this->toDate > $this->financialDates['to_date']) $this->toDate = $this->financialDates['to_date'];
        $query = Invoice::query();
        $query->where('invoice_type_id', '=', $this->invoice_type_id);
        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('invoice_date', [$this->fromDate, $this->toDate]);
        }

        $invoices = $query->with('items')->get();
        $type = InvoiceType::findOrFail($this->invoice_type_id);
        return view(
            'livewire.transaction.invoice-index',
            [
                'invoices' => $invoices,
                'type' => $type
            ]
        );
    }
}
