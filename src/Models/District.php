<?php

namespace Vermaysha\Wilayah\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'districts';

    /**
     * Model Constructor
     *
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('wilayah.table_names.district') ?? $this->table;
    }

    /**
     * City of this district
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
