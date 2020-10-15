<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};

class Transaction extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
