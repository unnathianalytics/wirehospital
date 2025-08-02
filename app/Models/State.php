<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    //
    protected $fillable = [
        'name',
        'code'
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
