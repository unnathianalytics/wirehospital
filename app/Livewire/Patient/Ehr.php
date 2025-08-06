<?php

namespace App\Livewire\Patient;

use Livewire\Component;

class Ehr extends Component
{
    public $ehr;
    public function mount($patient)
    {
        dd($patient);
        $this->ehr = Ehr::where('patient_id', $patient->id)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.patient.ehr');
    }
}
