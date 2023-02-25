<?php

namespace Vermaysha\LaravelWilayahID\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'villages';


    /**
     * Model Constructor
     *
     * @param array $attributes
     *
     * @return void
     *
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('wilayah-id.table_names.village') ?? $this->table;
    }

    /**
     * District of this village
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(
            District::class,
            'district_code',
            'code'
        );
    }
}
