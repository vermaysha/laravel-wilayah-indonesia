<?php

namespace Vermaysha\Wilayah\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Province extends Model
{
    /**
     * Cities of this province
     */
    public function cities(): HasMany
    {
        return $this->hasMany(
            City::class,
            'province_code',
            'code'
        );
    }

    /**
     * Districts of this province
     */
    public function districts(): HasManyThrough
    {
        return $this->hasManyThrough(
            District::class,
            City::class,
            'province_code',
            'city_code',
            'code',
            'code'
        );
    }
}
