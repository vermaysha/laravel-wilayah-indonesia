<?php

namespace Vermaysha\LaravelWilayahID\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    /**
     * City of this district
     *
     * @return BelongsTo
     *
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'city_code',
            'code'
        );
    }

    /**
     * Villages of this district
     *
     * @return HasMany
     *
     */
    public function villages(): HasMany
    {
        return $this->hasMany(
            Village::class,
            'district_code',
            'code'
        );
    }
}
