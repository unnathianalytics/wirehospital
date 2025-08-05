<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Discharge extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'id',
        'complaint_sheet_id',
        'status',
        'discharge_date',
        'doctor_assigned',
        'user',
    ];
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
    public function complaint_sheet() : BelongsTo
    {
        return $this->belongsTo(ComplaintSheet::class, 'complaint_sheet_id');
    }
}
