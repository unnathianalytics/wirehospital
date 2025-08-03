<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

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
}
