<?php

namespace App\Livewire\Master;

use App\Models\Ehr;
use Livewire\Component;
use App\Models\{Patient, State};

class PatientForm extends Component
{
    public ?Patient $patient = null;
    public $op_number, $name, $address, $mobile, $email, $gender, $date_of_birth, $occupation, $referred_by, $address_proof_id, $address_proof_number, $state_id;
    public function mount(?Patient $patient = null)
    {

        $this->patient = $patient;

        if ($patient?->exists) {
            $this->op_number = $patient->op_number;
            $this->name = $patient->name;
            $this->address = $patient->address;
            $this->state_id = $patient->state_id;
            $this->mobile = $patient->mobile;
            $this->email = $patient->email;
            $this->gender = $patient->gender;
            $this->date_of_birth = $patient->date_of_birth;
            $this->occupation = $patient->occupation;
            $this->referred_by = $patient->referred_by;
            $this->address_proof_id = $patient->address_proof_id;
            $this->address_proof_number = $patient->address_proof_number;
        } else {
            $this->patient = null;
            $this->op_number = Patient::newOpNumber();
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'op_number' => 'required',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'state_id' => 'required',
            'mobile' => 'nullable|numeric|min:6000000000|max:9999999999',
            'email' => 'nullable|email|max:255',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'occupation' => 'required|string|max:255',
            'referred_by' => 'required|string|max:255',
            'address_proof_id' => 'nullable|max:255',
            'address_proof_number' => 'nullable|max:255',
        ]);

        $patient = Patient::updateOrCreate(
            ['id' => $this->patient?->id],
            $validated
        );
        Ehr::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'doctor_assigned' => current_user()->id,
                'updated_by' => current_user()->id,
                'user' => current_user()->id
            ]
        );

        session()->flash('message', $this->patient ? 'Patient updated successfully.' : 'Patient created successfully.');
        return redirect()->route('patient_index');
    }


    public function render()
    {
        return view('livewire.master.patient-form', [
            'states' => State::orderBy('name')->get()
        ]);
    }
}
