<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];
    /**
     * @var mixed
     */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
