<?php

namespace Vermaysha\Wilayah\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * Model Constructor
     *
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('wilayah.table_names.city') ?? $this->table;
    }

    /**
     * Province of this city
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class,
            'province_code',
            'code'
        );
    }

    /**
     * Districts of this city
     */
    public function districts(): HasMany
    {
        return $this->hasMany(
            District::class,
            'city_code',
            'code'
        );
    }

    /**
     * Villages of thi city
     */
    public function villages(): HasManyThrough
    {
        return $this->hasManyThrough(
            Village::class,
            District::class,
            'city_code',
            'district_code',
            'code',
            'code'
        );
    }
}
