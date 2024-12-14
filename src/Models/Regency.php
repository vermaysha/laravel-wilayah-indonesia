<?php

namespace Vermaysha\Territory\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vermaysha\Territory\Traits\DefaultConfigTrait;
use Vermaysha\Territory\Traits\ReadOnlyTrait;

class Regency extends Model
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
        return config('territory.table_names.regencies', 'id_regencies');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return 'regency_code';
    }

    /**
     * Get the code of the regency.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getAttribute('regency_code');
    }

    /**
     * Get the name of the regency.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('regency_name');
    }

    /**
     * Get the province associated with the regency.
     *
     * This relationship is defined by a one-to-one association between
     * the Regency model and the Province model, using the province code
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
     * Get the districts associated with the regency.
     *
     * This relationship is defined by a one-to-many association between
     * the Regency model and the District model, using the regency code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts(): HasMany
    {
        $column = 'regency_code';

        return $this->hasMany(District::class, $column, $column);
    }
}
