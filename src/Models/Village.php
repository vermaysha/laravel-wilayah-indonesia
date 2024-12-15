<?php

namespace Vermaysha\Territory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vermaysha\Territory\Traits\DefaultConfigTrait;
use Vermaysha\Territory\Traits\ReadOnlyTrait;

class Village extends Model
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
        return config('territory_id.table_names.villages', 'id_villages');
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'village_code';
    }

    /**
     * Get the code of the village.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getAttribute('village_code');
    }

    /**
     * Get the name of the village.
     *
     * @return string The name of the village.
     */
    public function getName(): string
    {
        return $this->getAttribute('village_name');
    }

    /**
     * Get the province associated with the village.
     *
     * This relationship is defined by a one-to-one association between
     * the Village model and the Province model, using the province code
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
     * Get the regency associated with the village.
     *
     * This relationship is defined by a one-to-one association between
     * the Village model and the Regency model, using the regency code
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
     * Get the district associated with the village.
     *
     * This relationship is defined by a one-to-one association between
     * the Village model and the District model, using the district code
     * as the foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        $column = 'district_code';

        return $this->belongsTo(District::class, $column, $column);
    }
}
