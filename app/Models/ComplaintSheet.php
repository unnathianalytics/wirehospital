<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ComplaintSheet extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id',
        'case_no',
        'complaint_date',
        'complaint_type',
        'ip_number',
        'admission_date',
        'admission_time',
        'is_discharged',
        'floor_number',
        'room_number',
        'bed_number',
        'user',
    ];
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function complaint_followups() : HasMany
    {
        return $this->hasMany(ComplaintFollowup::class);
    }
    public function scopeNewCaseNumber() : string
    {
        $count = $this->whereYear(
            'created_at',
            '=',
            Carbon::now()->year,
        )->count() + 1;
        return "CS" . Carbon::now()->year . '/' . $count;
    }
    public function scopeNewIpNumber()
    {
        $count = $this->whereYear(
            'created_at',
            '=',
            Carbon::now()->year,
        )->where('complaint_type', '=', 'IP')->count() + 1;
        return "IP" . $count . '/' . Carbon::now()->year;
    }
}
