<?php

namespace App\Livewire\Patient;

use App\Models\Ehr;
use App\Models\Patient;
use Livewire\Component;

class EhrForm extends Component
{
    public $ehr,
        $patient_id,
        $present_complaints,
        $present_complaint_duration,
        $course_of_complaints,
        $past_complaints,
        $past_complaint_duration,
        $history_bp,
        $bp_duration,
        $history_sugar,
        $sugar_duration,
        $history_thyroid,
        $thyroid_duration,
        $others_history,
        $family_history,
        $treatment_history_type,
        $treatment_history_medications,
        $treatment_history_treatments,
        $surgical_history,
        $wakesup_at,
        $ushapana,
        $ushapana_quantity,
        $exercise,
        $exercise_duration,
        $bath,
        $breakfast,
        $nature_of_work,
        $nature_of_work_timings,
        $lunch,
        $snacks,
        $evening_exercise,
        $evening_exercise_nature_duration,
        $dinner,
        $bedtime,
        $vyasana,
        $vyasana_duration,
        $vyasana_frequency,
        $eao_agni,
        $eao_appetite,
        $eao_food_intake,
        $eao_food_quantity,
        $eao_ruchi,
        $eao_rasa_ichha,
        $eao_nature,
        $eao_nature_frequency,
        $eao_temperature_food_preferred_to_eat,
        $eao_udara,
        $eao_udara_if,
        $eao_water_intake_per_day,
        $eao_water_intake_relation_with_food,
        $eao_allergy_food,
        $eao_allergy_medicine,
        $eao_allergy_dust,
        $eao_allergy_pollen_grains,
        $eao_allergy_others,
        $eao_nidraa,
        $eao_nidra_timings,
        $eao_day_sleep,
        $eao_day_sleep_duration,
        $eao_gaatra,
        $eao_gaatra_symptoms,
        $eao_rajah_pravritti_menarche,
        $eao_rajah_pravritti_lmp,
        $eao_rajah_pravritti_cycle,
        $eao_rajah_pravritti_cycle_nature,
        $eao_rajah_pravritti_bleeding_days,
        $eao_perimenopause,
        $eao_menopause,
        $eao_postmenopause,
        $oh_no_deliveries,
        $oh_no_children,
        $oh_type,
        $oh_abortion,
        $oh_abortion_no,
        $oh_misscarriage,
        $oh_misscarriage_no,
        $oh_garbhini_soothika_charyaa,
        $oh_sterilisation,
        $asp_naadee,
        $asp_mutra_day,
        $asp_mutra_night,
        $asp_mutra_frequency,
        $asp_mutra_color,
        $asp_mutra_symptoms,
        $asp_mutra_others,
        $asp_mala_times,
        $asp_mala_pravrutti,
        $asp_mala_type,
        $asp_mala_digetion,
        $asp_mala_evacuation,
        $asp_jihwa_color,
        $asp_jihwa_coating,
        $asp_jihwa_others,
        $asp_shabda,
        $asp_sparsha,
        $asp_drik_conjunctiva,
        $asp_drik_sclera,
        $asp_drik_cornea,
        $asp_drik_eyelid,
        $asp_drik_other,
        $asp_akruthi_built,
        $asp_akruthi_height,
        $asp_akruthi_weight,
        $asp_akruthi_bmi,
        $ge_bp,
        $ge_pulse,
        $ge_heart_rate,
        $ge_respiratory_rate,
        $ge_temperature,
        $ge_icterus,
        $ge_edema,
        $ge_edema_other,
        $ge_cyanosis,
        $ge_lymph_node,
        $ge_others,
        $dvp_desha,
        $dvp_dooshya,
        $dvp_bala_roga,
        $dvp_bala_rogi,
        $dvp_kaala,
        $dvp_anala,
        $dvp_prakruti,
        $dvp_vaya,
        $dvp_satva,
        $dvp_satva_stress,
        $dvp_saatmya,
        $dvp_vihaara_vyayama,
        $dvp_others,
        $probable_diagnosis,
        $tp_treatment_plan,
        $tp_treatment_plan_guidelines,
        $lab_reports,
        $doctor_assigned;

    public function mount($patient)
    {
        $this->ehr = Ehr::where('patient_id', $patient)->firstOrFail();
        foreach ($this->ehr->getAttributes() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    protected function rules()
    {
        return [
            'present_complaints' => 'required|string|max:1000',
            'present_complaint_duration' => 'nullable|string|max:255',
            'course_of_complaints' => 'nullable|string|max:1000',
            'history_bp' => 'nullable|string|max:255',
            'bp_duration' => 'nullable|string|max:255',
            'exercise' => 'nullable|string|max:255',
            'exercise_duration' => 'nullable|string|max:255',
            // Add more rules...
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $this->ehr->fill([
            'patient_id' => $this->ehr->patient->id,
            ...$validated,
        ])->save();

        session()->flash('success', 'EHR updated successfully.');
    }

    public function render()
    {
        return view('livewire.patient.ehr-form');
    }
}
