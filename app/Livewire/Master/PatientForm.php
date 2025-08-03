<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\{Patient, State};

class PatientForm extends Component
{
    public ?Patient $patient = null;
    public $name, $address, $mobile, $state_id, $email, $is_registered = false, $gstin, $op_balance, $cr_dr, $is_editable = true, $is_deletable = true;
    public $states;
    public function mount(?Patient $patient = null)
    {
        $this->states = State::orderBy('name')->get();

        $this->patient = $patient;

        if ($patient?->exists) {
            $this->name = $patient->name;
            $this->address = $patient->address;
            $this->mobile = $patient->mobile;
            $this->email = $patient->email;
            $this->state_id = $patient->state_id;
        } else {
            $this->patient = null;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'mobile' => 'nullable|numeric|min:6000000000|max:9999999999',
            'email' => 'nullable|email|max:255',
            'state_id' => 'required|exists:states,id',
        ]);
        Patient::updateOrCreate(
            ['id' => $this->patient?->id],
            $validated
        );

        session()->flash('message', $this->patient ? 'Patient updated successfully.' : 'Patient created successfully.');
        return redirect()->route('patient_index');
    }


    public function render()
    {
        return view('livewire.master.patient-form');
    }
}
