<?php

namespace Vermaysha\LaravelWilayahID\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'city_code',
            'code'
        );
    }

    public function villages(): HasMany
    {
        return $this->hasMany(
            Village::class,
            'district_code',
            'code'
        );
    }
}
