<?php

namespace Vermaysha\LaravelWilayahID\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    public function district(): BelongsTo
    {
        return $this->belongsTo(
            District::class,
            'district_code',
            'code'
        );
    }
}
