<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\{AccountGroup, Account, State};

class AccountForm extends Component
{
    public ?Account $account = null;
    public $group_id, $name, $address, $mobile, $state_id, $email, $is_registered = false, $gstin, $op_balance, $cr_dr, $is_editable = true, $is_deletable = true;
    public $crdr_values = [];
    public $groups;
    public $states;
    public function mount(?Account $account = null)
    {
        $this->groups = AccountGroup::all();
        $this->states = State::orderBy('name')->get();
        $this->crdr_values = ['cr' => 'Credit', 'dr' => 'Debit'];

        $this->account = $account;

        if ($account && $account->exists) {
            $this->group_id = $account->group_id;
            $this->name = $account->name;
            $this->address = $account->address;
            $this->mobile = $account->mobile;
            $this->email = $account->email;
            $this->is_registered = $account->is_registered;
            $this->state_id = $account->state_id;
            $this->gstin = $account->gstin;
            $this->op_balance = $account->op_balance;
            $this->cr_dr = $account->cr_dr;
            $this->is_editable = $account->is_editable;
            $this->is_deletable = $account->is_deletable;
        } else {
            $this->account = null;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:account_groups,id',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|numeric|min:6000000000|max:9999999999',
            'email' => 'nullable|email|max:255',
            'is_registered' => 'boolean',
            'state_id' => 'required|exists:states,id',
            'gstin' => [
                $this->is_registered ? 'required' : 'nullable',
                'string',
                'max:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            ],
            'op_balance' => 'required|numeric',
            'cr_dr' => 'required',
        ]);

        if ($this->is_registered && $this->gstin && strlen($this->gstin) >= 2) {
            $gstinStateCode = (int)substr($this->gstin, 0, 2);
            $state = State::find($this->state_id);
            if ($state && $state->code !== $gstinStateCode) {
                $this->addError('gstin', 'The GSTIN state code does not match the code for the selected state.');
                return;
            }
        }

        if ($this->account && !$this->account->is_editable) {
            $this->group_id = $this->account->group_id;
            //$this->addError('Account', 'Default account disabled for edit');
            //return;
        }
        Account::updateOrCreate(
            ['id' => $this->account?->id],
            $validated
        );

        return redirect()->route('account_index');
    }

    public function render()
    {
        return view('livewire.master.account-form');
    }
}
