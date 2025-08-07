<?php

namespace App\Livewire\Patient;

use App\Models\{Ehr, Patient};
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
        $family_hisory,
        $treatment_history_type,
        $treatment_history_medications,
        $treatment_history_treatments,
        $surgical_history,
        $wakesup_at,
        $ushapana,
        $ushapana_quantity,
        $exercise,
        $exercise_duation,
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
        $this->present_complaints = $this->ehr->present_complaints;
        $this->present_complaint_duration = $this->ehr->present_complaint_duration;
        $this->course_of_complaints = $this->ehr->course_of_complaints;
        $this->past_complaints = $this->ehr->past_complaints;
        $this->past_complaint_duration = $this->ehr->past_complaint_duration;
        $this->history_bp = $this->ehr->history_bp;
        $this->bp_duration = $this->ehr->bp_duration;
        $this->history_sugar = $this->ehr->history_sugar;
        $this->sugar_duration = $this->ehr->sugar_duration;
        $this->history_thyroid = $this->ehr->history_thyroid;
        $this->thyroid_duration = $this->ehr->thyroid_duration;
        $this->others_history = $this->ehr->others_history;
        $this->family_hisory = $this->ehr->family_hisory;
        $this->treatment_history_type = $this->ehr->treatment_history_type;
        $this->treatment_history_medications = $this->ehr->treatment_history_medications;
        $this->treatment_history_treatments = $this->ehr->treatment_history_treatments;
        $this->surgical_history = $this->ehr->surgical_history;
        $this->wakesup_at = $this->ehr->wakesup_at;
        $this->ushapana = $this->ehr->ushapana;
        $this->ushapana_quantity = $this->ehr->ushapana_quantity;
        $this->exercise = $this->ehr->exercise;
        $this->exercise_duation = $this->ehr->exercise_duation;
        $this->bath = $this->ehr->bath;
        $this->breakfast = $this->ehr->breakfast;
        $this->nature_of_work = $this->ehr->nature_of_work;
        $this->nature_of_work_timings = $this->ehr->nature_of_work_timings;
        $this->lunch = $this->ehr->lunch;
        $this->snacks = $this->ehr->snacks;
        $this->evening_exercise = $this->ehr->evening_exercise;
        $this->evening_exercise_nature_duration = $this->ehr->evening_exercise_nature_duration;
        $this->dinner = $this->ehr->dinner;
        $this->bedtime = $this->ehr->bedtime;
        $this->vyasana = $this->ehr->vyasana;
        $this->vyasana_duration = $this->ehr->vyasana_duration;
        $this->vyasana_frequency = $this->ehr->vyasana_frequency;
        $this->eao_agni = $this->ehr->eao_agni;
        $this->eao_appetite = $this->ehr->eao_appetite;
        $this->eao_food_intake = $this->ehr->eao_food_intake;
        $this->eao_food_quantity = $this->ehr->eao_food_quantity;
        $this->eao_ruchi = $this->ehr->eao_ruchi;
        $this->eao_rasa_ichha = $this->ehr->eao_rasa_ichha;
        $this->eao_nature = $this->ehr->eao_nature;
        $this->eao_nature_frequency = $this->ehr->eao_nature_frequency;
        $this->eao_temperature_food_preferred_to_eat = $this->ehr->eao_temperature_food_preferred_to_eat;
        $this->eao_udara = $this->ehr->eao_udara;
        $this->eao_udara_if = $this->ehr->eao_udara_if;
        $this->eao_water_intake_per_day = $this->ehr->eao_water_intake_per_day;
        $this->eao_water_intake_relation_with_food = $this->ehr->eao_water_intake_relation_with_food;
        $this->eao_allergy_food = $this->ehr->eao_allergy_food;
        $this->eao_allergy_medicine = $this->ehr->eao_allergy_medicine;
        $this->eao_allergy_dust = $this->ehr->eao_allergy_dust;
        $this->eao_allergy_pollen_grains = $this->ehr->eao_allergy_pollen_grains;
        $this->eao_allergy_others = $this->ehr->eao_allergy_others;
        $this->eao_nidraa = $this->ehr->eao_nidraa;
        $this->eao_nidra_timings = $this->ehr->eao_nidra_timings;
        $this->eao_day_sleep = $this->ehr->eao_day_sleep;
        $this->eao_day_sleep_duration = $this->ehr->eao_day_sleep_duration;
        $this->eao_gaatra = $this->ehr->eao_gaatra;
        $this->eao_gaatra_symptoms = $this->ehr->eao_gaatra_symptoms;
        $this->eao_rajah_pravritti_menarche = $this->ehr->eao_rajah_pravritti_menarche;
        $this->eao_rajah_pravritti_lmp = $this->ehr->eao_rajah_pravritti_lmp;
        $this->eao_rajah_pravritti_cycle = $this->ehr->eao_rajah_pravritti_cycle;
        $this->eao_rajah_pravritti_cycle_nature = $this->ehr->eao_rajah_pravritti_cycle_nature;
        $this->eao_rajah_pravritti_bleeding_days = $this->ehr->eao_rajah_pravritti_bleeding_days;
        $this->eao_perimenopause = $this->ehr->eao_perimenopause;
        $this->eao_menopause = $this->ehr->eao_menopause;
        $this->eao_postmenopause = $this->ehr->eao_postmenopause;
        $this->oh_no_deliveries = $this->ehr->oh_no_deliveries;
        $this->oh_no_children = $this->ehr->oh_no_children;
        $this->oh_type = $this->ehr->oh_type;
        $this->oh_abortion = $this->ehr->oh_abortion;
        $this->oh_abortion_no = $this->ehr->oh_abortion_no;
        $this->oh_misscarriage = $this->ehr->oh_misscarriage;
        $this->oh_misscarriage_no = $this->ehr->oh_misscarriage_no;
        $this->oh_garbhini_soothika_charyaa = $this->ehr->oh_garbhini_soothika_charyaa;
        $this->oh_sterilisation = $this->ehr->oh_sterilisation;
        $this->asp_naadee = $this->ehr->asp_naadee;
        $this->asp_mutra_day = $this->ehr->asp_mutra_day;
        $this->asp_mutra_night = $this->ehr->asp_mutra_night;
        $this->asp_mutra_frequency = $this->ehr->asp_mutra_frequency;
        $this->asp_mutra_color = $this->ehr->asp_mutra_color;
        $this->asp_mutra_symptoms = $this->ehr->asp_mutra_symptoms;
        $this->asp_mutra_others = $this->ehr->asp_mutra_others;
        $this->asp_mala_times = $this->ehr->asp_mala_times;
        $this->asp_mala_pravrutti = $this->ehr->asp_mala_pravrutti;
        $this->asp_mala_type = $this->ehr->asp_mala_type;
        $this->asp_mala_digetion = $this->ehr->asp_mala_digetion;
        $this->asp_mala_evacuation = $this->ehr->asp_mala_evacuation;
        $this->asp_jihwa_color = $this->ehr->asp_jihwa_color;
        $this->asp_jihwa_coating = $this->ehr->asp_jihwa_coating;
        $this->asp_jihwa_others = $this->ehr->asp_jihwa_others;
        $this->asp_shabda = $this->ehr->asp_shabda;
        $this->asp_sparsha = $this->ehr->asp_sparsha;
        $this->asp_drik_conjunctiva = $this->ehr->asp_drik_conjunctiva;
        $this->asp_drik_sclera = $this->ehr->asp_drik_sclera;
        $this->asp_drik_cornea = $this->ehr->asp_drik_cornea;
        $this->asp_drik_eyelid = $this->ehr->asp_drik_eyelid;
        $this->asp_drik_other = $this->ehr->asp_drik_other;
        $this->asp_akruthi_built = $this->ehr->asp_akruthi_built;
        $this->asp_akruthi_height = $this->ehr->asp_akruthi_height;
        $this->asp_akruthi_weight = $this->ehr->asp_akruthi_weight;
        $this->asp_akruthi_bmi = $this->ehr->asp_akruthi_bmi;
        $this->ge_bp = $this->ehr->ge_bp;
        $this->ge_pulse = $this->ehr->ge_pulse;
        $this->ge_heart_rate = $this->ehr->ge_heart_rate;
        $this->ge_respiratory_rate = $this->ehr->ge_respiratory_rate;
        $this->ge_temperature = $this->ehr->ge_temperature;
        $this->ge_icterus = $this->ehr->ge_icterus;
        $this->ge_edema = $this->ehr->ge_edema;
        $this->ge_edema_other = $this->ehr->ge_edema_other;
        $this->ge_cyanosis = $this->ehr->ge_cyanosis;
        $this->ge_lymph_node = $this->ehr->ge_lymph_node;
        $this->ge_others = $this->ehr->ge_others;
        $this->dvp_desha = $this->ehr->dvp_desha;
        $this->dvp_dooshya = $this->ehr->dvp_dooshya;
        $this->dvp_bala_roga = $this->ehr->dvp_bala_roga;
        $this->dvp_bala_rogi = $this->ehr->dvp_bala_rogi;
        $this->dvp_kaala = $this->ehr->dvp_kaala;
        $this->dvp_anala = $this->ehr->dvp_anala;
        $this->dvp_prakruti = $this->ehr->dvp_prakruti;
        $this->dvp_vaya = $this->ehr->dvp_vaya;
        $this->dvp_satva = $this->ehr->dvp_satva;
        $this->dvp_satva_stress = $this->ehr->dvp_satva_stress;
        $this->dvp_saatmya = $this->ehr->dvp_saatmya;
        $this->dvp_vihaara_vyayama = $this->ehr->dvp_vihaara_vyayama;
        $this->dvp_others = $this->ehr->dvp_others;
        $this->probable_diagnosis = $this->ehr->probable_diagnosis;
        $this->tp_treatment_plan = $this->ehr->tp_treatment_plan;
        $this->tp_treatment_plan_guidelines = $this->ehr->tp_treatment_plan_guidelines;
        $this->lab_reports = $this->ehr->lab_reports;
        $this->doctor_assigned = $this->ehr->doctor_assigned;
    }
    public function render()
    {
        return view('livewire.patient.ehr-form');
    }

    public function update()
    {
        $this->ehr->present_complaints = $this->present_complaints;
        $this->ehr->present_complaint_duration = $this->present_complaint_duration;
        $this->ehr->course_of_complaints = $this->course_of_complaints;
        $this->ehr->past_complaints = $this->past_complaints;
        $this->ehr->past_complaint_duration = $this->past_complaint_duration;
        $this->ehr->history_bp = $this->history_bp;
        $this->ehr->bp_duration = $this->bp_duration;
        $this->ehr->history_sugar = $this->history_sugar;
        $this->ehr->sugar_duration = $this->sugar_duration;
        $this->ehr->history_thyroid = $this->history_thyroid;
        $this->ehr->thyroid_duration = $this->thyroid_duration;
        $this->ehr->others_history = $this->others_history;
        $this->ehr->family_hisory = $this->family_hisory;
        $this->ehr->treatment_history_type = $this->treatment_history_type;
        $this->ehr->treatment_history_medications = $this->treatment_history_medications;
        $this->ehr->treatment_history_treatments = $this->treatment_history_treatments;
        $this->ehr->surgical_history = $this->surgical_history;
        $this->ehr->wakesup_at = $this->wakesup_at;
        $this->ehr->ushapana = $this->ushapana;
        $this->ehr->ushapana_quantity = $this->ushapana_quantity;
        $this->ehr->exercise = $this->exercise;
        $this->ehr->exercise_duation = $this->exercise_duation;
        $this->ehr->bath = $this->bath;
        $this->ehr->breakfast = $this->breakfast;
        $this->ehr->nature_of_work = $this->nature_of_work;
        $this->ehr->nature_of_work_timings = $this->nature_of_work_timings;
        $this->ehr->lunch = $this->lunch;
        $this->ehr->snacks = $this->snacks;
        $this->ehr->evening_exercise = $this->evening_exercise;
        $this->ehr->evening_exercise_nature_duration = $this->evening_exercise_nature_duration;
        $this->ehr->dinner = $this->dinner;
        $this->ehr->bedtime = $this->bedtime;
        $this->ehr->vyasana = $this->vyasana;
        $this->ehr->vyasana_duration = $this->vyasana_duration;
        $this->ehr->vyasana_frequency = $this->vyasana_frequency;
        $this->ehr->eao_agni = $this->eao_agni;
        $this->ehr->eao_appetite = $this->eao_appetite;
        $this->ehr->eao_food_intake = $this->eao_food_intake;
        $this->ehr->eao_food_quantity = $this->eao_food_quantity;
        $this->ehr->eao_ruchi = $this->eao_ruchi;
        $this->ehr->eao_rasa_ichha = $this->eao_rasa_ichha;
        $this->ehr->eao_nature = $this->eao_nature;
        $this->ehr->eao_nature_frequency = $this->eao_nature_frequency;
        $this->ehr->eao_temperature_food_preferred_to_eat = $this->eao_temperature_food_preferred_to_eat;
        $this->ehr->eao_udara = $this->eao_udara;
        $this->ehr->eao_udara_if = $this->eao_udara_if;
        $this->ehr->eao_water_intake_per_day = $this->eao_water_intake_per_day;
        $this->ehr->eao_water_intake_relation_with_food = $this->eao_water_intake_relation_with_food;
        $this->ehr->eao_allergy_food = $this->eao_allergy_food;
        $this->ehr->eao_allergy_medicine = $this->eao_allergy_medicine;
        $this->ehr->eao_allergy_dust = $this->eao_allergy_dust;
        $this->ehr->eao_allergy_pollen_grains = $this->eao_allergy_pollen_grains;
        $this->ehr->eao_allergy_others = $this->eao_allergy_others;
        $this->ehr->eao_nidraa = $this->eao_nidraa;
        $this->ehr->eao_nidra_timings = $this->eao_nidra_timings;
        $this->ehr->eao_day_sleep = $this->eao_day_sleep;
        $this->ehr->eao_day_sleep_duration = $this->eao_day_sleep_duration;
        $this->ehr->eao_gaatra = $this->eao_gaatra;
        $this->ehr->eao_gaatra_symptoms = $this->eao_gaatra_symptoms;
        $this->ehr->eao_rajah_pravritti_menarche = $this->eao_rajah_pravritti_menarche;
        $this->ehr->eao_rajah_pravritti_lmp = $this->eao_rajah_pravritti_lmp;
        $this->ehr->eao_rajah_pravritti_cycle = $this->eao_rajah_pravritti_cycle;
        $this->ehr->eao_rajah_pravritti_cycle_nature = $this->eao_rajah_pravritti_cycle_nature;
        $this->ehr->eao_rajah_pravritti_bleeding_days = $this->eao_rajah_pravritti_bleeding_days;
        $this->ehr->eao_perimenopause = $this->eao_perimenopause;
        $this->ehr->eao_menopause = $this->eao_menopause;
        $this->ehr->eao_postmenopause = $this->eao_postmenopause;
        $this->ehr->oh_no_deliveries = $this->oh_no_deliveries;
        $this->ehr->oh_no_children = $this->oh_no_children;
        $this->ehr->oh_type = $this->oh_type;
        $this->ehr->oh_abortion = $this->oh_abortion;
        $this->ehr->oh_abortion_no = $this->oh_abortion_no;
        $this->ehr->oh_misscarriage = $this->oh_misscarriage;
        $this->ehr->oh_misscarriage_no = $this->oh_misscarriage_no;
        $this->ehr->oh_garbhini_soothika_charyaa = $this->oh_garbhini_soothika_charyaa;
        $this->ehr->oh_sterilisation = $this->oh_sterilisation;
        $this->ehr->asp_naadee = $this->asp_naadee;
        $this->ehr->asp_mutra_day = $this->asp_mutra_day;
        $this->ehr->asp_mutra_night = $this->asp_mutra_night;
        $this->ehr->asp_mutra_frequency = $this->asp_mutra_frequency;
        $this->ehr->asp_mutra_color = $this->asp_mutra_color;
        $this->ehr->asp_mutra_symptoms = $this->asp_mutra_symptoms;
        $this->ehr->asp_mutra_others = $this->asp_mutra_others;
        $this->ehr->asp_mala_times = $this->asp_mala_times;
        $this->ehr->asp_mala_pravrutti = $this->asp_mala_pravrutti;
        $this->ehr->asp_mala_type = $this->asp_mala_type;
        $this->ehr->asp_mala_digetion = $this->asp_mala_digetion;
        $this->ehr->asp_mala_evacuation = $this->asp_mala_evacuation;
        $this->ehr->asp_jihwa_color = $this->asp_jihwa_color;
        $this->ehr->asp_jihwa_coating = $this->asp_jihwa_coating;
        $this->ehr->asp_jihwa_others = $this->asp_jihwa_others;
        $this->ehr->asp_shabda = $this->asp_shabda;
        $this->ehr->asp_sparsha = $this->asp_sparsha;
        $this->ehr->asp_drik_conjunctiva = $this->asp_drik_conjunctiva;
        $this->ehr->asp_drik_sclera = $this->asp_drik_sclera;
        $this->ehr->asp_drik_cornea = $this->asp_drik_cornea;
        $this->ehr->asp_drik_eyelid = $this->asp_drik_eyelid;
        $this->ehr->asp_drik_other = $this->asp_drik_other;
        $this->ehr->asp_akruthi_built = $this->asp_akruthi_built;
        $this->ehr->asp_akruthi_height = $this->asp_akruthi_height;
        $this->ehr->asp_akruthi_weight = $this->asp_akruthi_weight;
        $this->ehr->asp_akruthi_bmi = $this->asp_akruthi_bmi;
        $this->ehr->ge_bp = $this->ge_bp;
        $this->ehr->ge_pulse = $this->ge_pulse;
        $this->ehr->ge_heart_rate = $this->ge_heart_rate;
        $this->ehr->ge_respiratory_rate = $this->ge_respiratory_rate;
        $this->ehr->ge_temperature = $this->ge_temperature;
        $this->ehr->ge_icterus = $this->ge_icterus;
        $this->ehr->ge_edema = $this->ge_edema;
        $this->ehr->ge_edema_other = $this->ge_edema_other;
        $this->ehr->ge_cyanosis = $this->ge_cyanosis;
        $this->ehr->ge_lymph_node = $this->ge_lymph_node;
        $this->ehr->ge_others = $this->ge_others;
        $this->ehr->dvp_desha = $this->dvp_desha;
        $this->ehr->dvp_dooshya = $this->dvp_dooshya;
        $this->ehr->dvp_bala_roga = $this->dvp_bala_roga;
        $this->ehr->dvp_bala_rogi = $this->dvp_bala_rogi;
        $this->ehr->dvp_kaala = $this->dvp_kaala;
        $this->ehr->dvp_anala = $this->dvp_anala;
        $this->ehr->dvp_prakruti = $this->dvp_prakruti;
        $this->ehr->dvp_vaya = $this->dvp_vaya;
        $this->ehr->dvp_satva = $this->dvp_satva;
        $this->ehr->dvp_satva_stress = $this->dvp_satva_stress;
        $this->ehr->dvp_saatmya = $this->dvp_saatmya;
        $this->ehr->dvp_vihaara_vyayama = $this->dvp_vihaara_vyayama;
        $this->ehr->dvp_others = $this->dvp_others;
        $this->ehr->probable_diagnosis = $this->probable_diagnosis;
        $this->ehr->tp_treatment_plan = $this->tp_treatment_plan;
        $this->ehr->tp_treatment_plan_guidelines = $this->tp_treatment_plan_guidelines;
        $this->ehr->lab_reports = $this->lab_reports;
        $this->ehr->doctor_assigned = $this->doctor_assigned;
        $s = $this->ehr->save();
    }
}
