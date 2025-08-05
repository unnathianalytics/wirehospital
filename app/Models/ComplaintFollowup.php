<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class ComplaintFollowup extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'complaint_sheet_id',
        'followup_date',
        'previous_complaint_status',
        'fresh_complaints_any',
        'fresh_complaints_duration',
        'asp_naadee',
        'asp_mutra_day',
        'asp_mutra_night',
        'asp_mutra_frequency',
        'asp_mutra_color',
        'asp_mutra_symptoms',
        'asp_mutra_others',
        'asp_mala_times',
        'asp_mala_pravrutti',
        'asp_mala_type',
        'asp_mala_digetion',
        'asp_mala_evacuation',
        'asp_jihwa_color',
        'asp_jihwa_coating',
        'asp_jihwa_others',
        'asp_shabda',
        'asp_sparsha',
        'asp_drik_conjunctiva',
        'asp_drik_sclera',
        'asp_drik_cornea',
        'asp_drik_eyelid',
        'asp_drik_other',
        'eao_agni',
        'eao_appetite',
        'eao_food_intake',
        'eao_food_quantity',
        'eao_ruchi',
        'eao_rasa_ichha',
        'eao_udara',
        'eao_udara_if',
        'eao_nidraa',
        'eao_gaatra',
        'eao_gaatra_symptoms',
        'eao_rajah_pravritti_lmp',
        'eao_rajah_pravritti_cycle',
        'eao_rajah_pravritti_cycle_nature',
        'eao_rajah_pravritti_bleeding_days',
        'oh_no_deliveries',
        'oh_no_children',
        'oh_type',
        'oh_abortion',
        'oh_abortion_no',
        'oh_misscarriage',
        'oh_misscarriage_no',
        'oh_garbhini_soothika_charyaa',
        'oh_sterilisation',
        'ge_bp',
        'ge_pulse',
        'ge_heart_rate',
        'ge_respiratory_rate',
        'ge_temperature',
        'ge_icterus',
        'ge_edema',
        'ge_edema_other',
        'ge_cyanosis',
        'ge_lymph_node',
        'ge_others',
        'grbs',
        'weight',
        'conclusion',
        'tp_treatment_plan',
        'tp_treatment_plan_guidelines',
        'probable_diagnosis',
        'lab_reports',
        'doctor_assigned',
        'user',
    ];
    protected $casts = [
        'lab_reports' => 'array',
    ];
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
    public function complaint_sheet() : BelongsTo
    {
        return $this->belongsTo(ComplaintSheet::class, 'complaint_sheet_id');
    }
    public function invoice_items() : HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'parent_id');
    }
    public function prescription_medicines() : HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'parent_id')->where('parent_model', '=', 'prescription_item');
    }
    public function prescription_treatments() : HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'parent_id')->where('parent_model', '=', 'prescription_treatment');
    }
}
