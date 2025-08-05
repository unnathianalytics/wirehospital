<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Account
{
    protected $table = 'accounts';
    //
    protected static function booted()
    {
        // Always apply the condition group_id = 32
        static::addGlobalScope('patient_group', function (Builder $builder) {
            $builder->where('group_id', 32);
        });

        // Ensure group_id is always 32 on create
        static::creating(function ($model) {
            $model->group_id = 32;
        });
    }
    public static function newOpNumber()
    {
        $count = self::where(
            'created_at',
            '>',
            Carbon::createFromFormat('Y-m-d H:i:s', now())->year,
        )->count() + 1;

        return "OP" . $count . '/' . date('Y');
    }

    public function ehr(): HasOne
    {
        return $this->hasOne(EHR::class, 'patient_id');
    }
}
