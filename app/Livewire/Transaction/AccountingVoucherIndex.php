<?php

namespace App\Livewire\Transaction;

use App\Models\AccountingType;
use App\Models\AccountingVoucher;
use Livewire\Component;

class AccountingVoucherIndex extends Component
{
    public $fromDate;
    public $toDate;
    public string $accountingType;
    public string $accounting_type_id;

    public function mount()
    {
        $dates = getUserFinancialYearDates();
        //$today = now()->format('Y-m-d');
        $this->fromDate = $dates['from_date'];
        $this->toDate = $dates['to_date'];
    }
    public function render()
    {

        $query = AccountingVoucher::query();
        $query->where('accounting_type_id', '=', $this->accounting_type_id);
        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('transaction_date', [$this->fromDate, $this->toDate]);
        }

        $accountingVouchers = $query->with('accountingVoucherItems.debit_acc', 'accountingVoucherItems.credit_acc',)->latest()->get();


        $type = AccountingType::findOrFail($this->accounting_type_id);

        return view(
            'livewire.transaction.accounting-voucher-index',
            [
                'accountingVouchers' => $accountingVouchers,
                'type' => $type
            ]
        );
    }
}
