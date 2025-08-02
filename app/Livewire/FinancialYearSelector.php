<?php

namespace App\Livewire;

use Auth;
use App\Models\User;
use App\Models\FinancialYear;
use Livewire\Component;

class FinancialYearSelector extends Component
{
    public $selectedFinancialYear;
    public $financialYears;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->financialYears = FinancialYear::where('company_id', $this->user->company_id)
            ->where('is_active', true)
            ->get();
        $this->selectedFinancialYear = $this->user->financial_year_id;
    }

    public function updateAndLogout($financialYearId)
    {
        $financialYear = FinancialYear::where('id', $financialYearId)
            ->where('company_id', $this->user->company_id)
            ->first();

        if ($financialYear) {
            $this->user->update(['financial_year_id' => $financialYearId]);
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return $this->redirect('/login', navigate: true);
        } else {
            $this->selectedFinancialYear = $this->user->financial_year_id;
            session()->flash('error', 'Invalid financial year selected.');
        }
    }

    public function render()
    {
        return view('livewire.financial-year-selector');
    }
}
