<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class ShoppingCart extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity', 'unit_price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getSubtotal():string
    {
        $subtotal = 0.0;
        foreach($this->books as $book){
            $subtotal += ($book->pivot->quantity * $book->pivot->unit_price);
        }

        return $this->formattedPrice($subtotal);
    }

    /**
     * @param  int $price
     * @return false|string
     */
    public function formattedPrice(int $price)
    {
        $amount = new NumberFormatter('es_CO', NumberFormatter::CURRENCY);

        return $amount->format($price);
    }

}
