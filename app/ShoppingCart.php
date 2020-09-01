<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $guarded = [];

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity', 'unit_price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
