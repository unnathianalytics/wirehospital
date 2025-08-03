<?php

namespace App\Livewire\Transaction;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\InvoiceType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $this->fromDate = Carbon::parse($this->financialDates['from_date'])->format('d-m-Y');
        $this->toDate = Carbon::parse($this->financialDates['to_date'])->format('d-m-Y');
        $this->showItems = 'no';
        Log::info($this->fromDate . '##' . $this->toDate);
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['fromDate', 'toDate'])) {
            try {
                Carbon::createFromFormat('d-m-Y', $this->fromDate);
                Carbon::createFromFormat('d-m-Y', $this->toDate);
            } catch (\Exception $e) {
                // Reset to default if invalid
                if ($propertyName === 'fromDate') {
                    $this->fromDate = Carbon::parse($this->financialDates['from_date'])->format('d-m-Y');
                } elseif ($propertyName === 'toDate') {
                    $this->toDate = Carbon::parse($this->financialDates['to_date'])->format('d-m-Y');
                }
            }
        }
    }

    public function filter()
    {
        // This method can be left empty or used to add additional logic before refreshing
        $this->render();
    }

    public function render()
    {
        try {
            $parsedFrom = Carbon::createFromFormat('d-m-Y', $this->fromDate)->format('Y-m-d');
        } catch (\Exception $e) {
            $parsedFrom = $this->financialDates['from_date'];
            $this->fromDate = Carbon::parse($parsedFrom)->format('d-m-Y');
        }

        try {
            $parsedTo = Carbon::createFromFormat('d-m-Y', $this->toDate)->format('Y-m-d');
        } catch (\Exception $e) {
            $parsedTo = $this->financialDates['to_date'];
            $this->toDate = Carbon::parse($parsedTo)->format('d-m-Y');
        }

        if ($parsedFrom < $this->financialDates['from_date']) {
            $this->fromDate = Carbon::parse($this->financialDates['from_date'])->format('d-m-Y');
            $parsedFrom = $this->financialDates['from_date'];
        }
        if ($parsedTo > $this->financialDates['to_date']) {
            $this->toDate = Carbon::parse($this->financialDates['to_date'])->format('d-m-Y');
            $parsedTo = $this->financialDates['to_date'];
        }

        DB::enableQueryLog();
        $query = Invoice::query();
        $query->where('invoice_type_id', '=', $this->invoice_type_id);
        if ($this->fromDate && $this->toDate) {
            try {
                $from = Carbon::createFromFormat('d-m-Y', $this->fromDate)->format('Y-m-d');
                $to = Carbon::createFromFormat('d-m-Y', $this->toDate)->format('Y-m-d');
                $query->whereBetween('invoice_date', [$from, $to]);
            } catch (\Exception $e) {
                Log::error('Date parsing error: ' . $e->getMessage());
            }
        }
        $invoices = $query->with('items')->get();
        $queries = DB::getQueryLog();

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
