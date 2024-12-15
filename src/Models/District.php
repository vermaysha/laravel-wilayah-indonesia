<?php

namespace Vermaysha\Territory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vermaysha\Territory\Traits\DefaultConfigTrait;
use Vermaysha\Territory\Traits\ReadOnlyTrait;

class District extends Model
{
    use DefaultConfigTrait, ReadOnlyTrait;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('territory_id.table_names.districts', 'id_districts');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return 'district_code';
    }

    /**
     * Get the code of the district.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getAttribute('district_code');
    }

    /**
     * Get the name of the district.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('district_name');
    }

    /**
     * Get the province associated with the district.
     *
     * This relationship is defined by a one-to-one association between
     * the District model and the Province model, using the province code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        $column = 'province_code';

        return $this->belongsTo(Province::class, $column, $column);
    }

    /**
     * Get the regency associated with the district.
     *
     * This relationship is defined by a one-to-one association between
     * the District model and the Regency model, using the regency code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency(): BelongsTo
    {
        $column = 'regency_code';

        return $this->belongsTo(Regency::class, $column, $column);
    }

    /**
     * Get the villages associated with the district.
     *
     * This relationship is defined by a one-to-many association between
     * the District model and the Village model, using the district code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages(): HasMany
    {
        $column = 'district_code';

        return $this->hasMany(Village::class, $column, $column);
    }
}
