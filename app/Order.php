<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Order extends Model
{
    protected $guarded = [];
    public $subtotal;
    public $paymentStatus;
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
    public function getFormattedSubtotal():string
    {
        return $this->formattedPrice($this->getSubtotal());
    }

    public function getSubtotal()
    {
        $subtotal = 0.0;
        foreach($this->books as $book){
            $subtotal += ($book->pivot->quantity * $book->pivot->unit_price);
        }
        return $subtotal;
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function paymentStatus()
    {
        $lastTransaction = $this->transactions->sortByDesc('id')->first();
        if (isset($lastTransaction['status'])){
            return $lastTransaction['status'];
        }
        else{
            return '(No transaction)';
        }
    }

    public function retryPayment()
    {
        return ($this->paymentStatus() === 'REJECTED') ?: false;
    }


}

