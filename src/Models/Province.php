<?php

namespace Vermaysha\Territory\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vermaysha\Territory\Traits\DefaultConfigTrait;
use Vermaysha\Territory\Traits\ReadOnlyTrait;

class Province extends Model
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
        return config('territory.table_names.provinces', 'id_provinces');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return 'province_code';
    }

    /**
     * Get the code of the province.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getAttribute('province_code');
    }

    /**
     * Get the name of the province.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('province_name');
    }

    /**
     * Get the regencies associated with the province.
     *
     * This relationship is defined by a one-to-many association between
     * the Province model and the Regency model, using the province code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regencies(): HasMany
    {
        $column = 'province_code';

        return $this->hasMany(Regency::class, $column, $column);
    }

    /**
     * Get the districts associated with the province.
     *
     * This relationship is defined by a one-to-many association between
     * the Province model and the District model, using the province code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts(): HasMany
    {
        $column = 'province_code';

        return $this->hasMany(District::class, $column, $column);
    }

    /**
     * Get the villages associated with the province.
     *
     * This relationship is defined by a one-to-many association between
     * the Province model and the Village model, using the province code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages(): HasMany
    {
        $column = 'province_code';

        return $this->hasMany(Village::class, $column, $column);
    }
}
