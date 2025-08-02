<?php

namespace App\Livewire\Transaction;

use App\Models\Account;
use App\Models\AccountingType;
use App\Models\AccountingVoucher;
use App\Models\AccountingVoucherItem;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class AccountingVoucherForm extends Component
{
    public AccountingVoucher $voucher;
    public string $accountingType;
    public array $accountingVoucherItems = [];
    public $accountingVoucher;
    public $availableAccounts = [];
    public array $accountingVoucherData = [];

    public string $avcSel;
    public $dr_accounts = [];
    public $cr_accounts = [];
    public $financial_year_id;

    public function mount(string $accountingType, ?int $accountingVoucherId = null)
    {
        $this->accountingType = $accountingType;

        $accountingTypeModel = AccountingType::where('slug', $accountingType)->firstOrFail();
        $this->accountingType = $accountingTypeModel->slug;

        switch ($accountingTypeModel->id) {
            case 1:
                //receipt
                $this->cr_accounts = Account::whereIn('group_id', [20, 16, 1, 18, 25, 27, 4, 7, 14, 30, 9, 28, 29, 10, 26])->orderBy('name')->get();
                $this->dr_accounts = Account::whereIn('group_id', [11, 12, 21])->orderBy('name')->get();
                break;
            case 2:
                //contra
                $this->dr_accounts = $this->cr_accounts = Account::whereIn('group_id', [11, 12, 21])->orderBy('name')->get();
                break;
            case 3:
                //payment
                $this->dr_accounts = Account::whereIn('group_id', [20, 16, 1, 18, 25, 27, 4, 7, 14, 30, 9, 28, 29, 10, 26])->orderBy('name')->get();
                $this->cr_accounts = Account::whereIn('group_id', [11, 12, 21])->orderBy('name')->get();
                break;
            default:
                //journal
                $this->cr_accounts = $this->dr_accounts = Account::orderBy('name')->get();
        }

        $this->accountingVoucher = $accountingVoucherId
            ? $this->loadAccountingVoucherModel($accountingVoucherId)
            : $this->newAccountingVoucherModel($accountingTypeModel->id);

        $this->voucher = $this->accountingVoucher;

        $this->accountingVoucherData = [
            'voucher_series_id' => 1,
            'transaction_date' => $this->accountingVoucher->transaction_date ?? now()->format('Y-m-d'),
            'transaction_time' => $this->accountingVoucher->transaction_time ?? now()->format('H:i'),
            'voucher_number' => $this->accountingVoucher->voucher_number ?? '',
            'description' => $this->accountingVoucher->description ?? '',
            'accounting_type_id' => $this->accountingVoucher->accounting_type_id ?? $accountingTypeModel->id,
        ];

        if ($accountingVoucherId) {
            $this->accountingVoucherItems = $this->accountingVoucher->accountingVoucherItems->map(fn($item) => [
                'id' => $item->id, // Include the item ID
                'avr_item_type' => $item->avr_item_type,
                'cr_account_id' => $item->cr_account_id,
                'dr_account_id' => $item->dr_account_id,
                'cr_amount' => $item->cr_amount,
                'dr_amount' => $item->dr_amount,
                'description' => $item->description,
            ])->toArray();
        } else {
            $avrType = $accountingTypeModel->id != 3 ? ['cr', 'dr'] : ['dr', 'cr'];

            $this->accountingVoucherItems = [
                ['id' => null, 'avr_item_type' => $avrType[0] ?? null, 'cr_account_id' => '', 'dr_account_id' => '', 'cr_amount' => 0, 'dr_amount' => 0, 'description' => ''],
                ['id' => null, 'avr_item_type' => $avrType[1] ?? null, 'cr_account_id' => '', 'dr_account_id' => '', 'cr_amount' => 0, 'dr_amount' => 0, 'description' => ''],
            ];
        }
    }

    protected function loadAccountingVoucherModel(int $id): AccountingVoucher
    {
        return AccountingVoucher::findOrFail($id);
    }

    protected function newAccountingVoucherModel(int $accountingTypeId): AccountingVoucher
    {
        return new AccountingVoucher(['accounting_type_id' => $accountingTypeId]);
    }

    public function addRow(): void
    {
        $this->accountingVoucherItems[] = [
            'id' => null,
            'avr_item_type' => null,
            'cr_account_id' => '',
            'dr_account_id' => '',
            'cr_amount' => 0,
            'dr_amount' => 0,
            'description' => ''
        ];
    }

    public function removeRow($index): void
    {
        if (count($this->accountingVoucherItems) > 2) {
            unset($this->accountingVoucherItems[$index]);
            $this->accountingVoucherItems = array_values($this->accountingVoucherItems);
        }
    }

    #[Computed]
    public function totalDebit()
    {
        return collect($this->accountingVoucherItems)->sum('dr_amount');
    }

    #[Computed]
    public function totalCredit()
    {
        return collect($this->accountingVoucherItems)->sum('cr_amount');
    }

    public function save()
    {
        $dates = getUserFinancialYearDates();
        if ($this->voucher->exists && current_user()->financial_year_id != $this->voucher->financial_year_id) {
            $this->addError('financial_year', 'You cannot edit vouchers from a different financial year.');
            return;
        }
        $this->validate([
            'accountingVoucherData.transaction_date' => 'required|date',
            'accountingVoucherData.voucher_number' => 'required|string',
            'accountingVoucherData.voucher_notes' => 'nullable|string',
            'accountingVoucherItems' => 'required|array|min:2',
            'accountingVoucherItems.*.avr_item_type' => 'required|in:cr,dr',
            'accountingVoucherItems.*.cr_account_id' => 'nullable|exists:accounts,id',
            'accountingVoucherItems.*.dr_account_id' => 'nullable|exists:accounts,id',
            'accountingVoucherItems.*.cr_amount' => 'required|numeric|min:0',
            'accountingVoucherItems.*.dr_amount' => 'required|numeric|min:0',
            'accountingVoucherItems.*.description' => 'nullable|string',
            'accountingVoucherItems.*' => [
                function ($attribute, $value, $fail) {
                    if ($value['avr_item_type'] === 'cr') {
                        if ($value['cr_amount'] <= 0) {
                            $fail("The {$attribute}.cr_amount must be greater than 0 when Cr/Dr is 'cr'.");
                        }
                        if ($value['dr_amount'] != 0) {
                            $fail("The {$attribute}.dr_amount must be 0 when Cr/Dr is 'cr'.");
                        }
                        if (empty($value['cr_account_id'])) {
                            $fail("The {$attribute}.cr_account_id is required when Cr/Dr is 'cr'.");
                        }
                    } elseif ($value['avr_item_type'] === 'dr') {
                        if ($value['dr_amount'] <= 0) {
                            $fail("The {$attribute}.dr_amount must be greater than 0 when Cr/Dr is 'dr'.");
                        }
                        if ($value['cr_amount'] != 0) {
                            $fail("The {$attribute}.cr_amount must be 0 when Cr/Dr is 'dr'.");
                        }
                        if (empty($value['dr_account_id'])) {
                            $fail("The {$attribute}.dr_account_id is required when Cr/Dr is 'dr'.");
                        }
                    }
                },
            ],
        ]);

        $totalCredit = $this->totalCredit;
        $totalDebit = $this->totalDebit;
        if ($totalCredit != $totalDebit) {
            $this->addError('accountingVoucherItems', 'Total debit and credit amounts must match.');
            return;
        }

        // Update the voucher
        $this->voucher->financial_year_id = current_user()->financial_year_id;
        $this->voucher->voucher_series_id = $this->accountingVoucherData['voucher_series_id'];
        $this->voucher->transaction_date = $this->accountingVoucherData['transaction_date'];
        $this->voucher->transaction_time = $this->accountingVoucherData['transaction_time'] ?? now()->format('H:i');
        $this->voucher->voucher_number = $this->accountingVoucherData['voucher_number'];
        $this->voucher->voucher_notes = $this->accountingVoucherData['voucher_notes'] ?? '';
        $this->voucher->accounting_type_id = $this->accountingVoucherData['accounting_type_id'];
        $this->voucher->save();
        $this->voucher->touch();

        // Get existing item IDs
        $existingItemIds = $this->voucher->accountingVoucherItems->pluck('id')->toArray();
        $submittedItemIds = array_filter(array_column($this->accountingVoucherItems, 'id'));

        // Update or create items
        foreach ($this->accountingVoucherItems as $itemData) {
            $itemDataToSave = [
                'avr_item_type' => $itemData['avr_item_type'],
                'cr_account_id' => $itemData['cr_account_id'],
                'dr_account_id' => $itemData['dr_account_id'],
                'cr_amount' => $itemData['cr_amount'],
                'dr_amount' => $itemData['dr_amount'],
                'description' => $itemData['description'],
            ];

            if (!empty($itemData['id'])) {
                // Update existing item
                $item = AccountingVoucherItem::find($itemData['id']);
                if ($item) {
                    $item->update($itemDataToSave);
                }
            } else {
                // Create new item
                $this->voucher->accountingVoucherItems()->create($itemDataToSave);
            }
        }

        // Delete removed items
        $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
        if (!empty($itemsToDelete)) {
            AccountingVoucherItem::whereIn('id', $itemsToDelete)->delete();
        }

        $accountingTypeSlug = AccountingType::findOrFail($this->voucher->accounting_type_id)->slug;
        return redirect()->route('accounting_voucher_index', ['accountingType' => $accountingTypeSlug]);
    }

    public function render()
    {
        Log::info('AccountingVoucherItems', ['items' => $this->accountingVoucherItems]);

        return view('livewire.transaction.accounting-voucher-form');
    }
}
