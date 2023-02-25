<?php

namespace Vermaysha\Wilayah\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
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
