<?php

namespace App;

use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    Relations\BelongsToMany,
    Relations\HasMany
};
use NumberFormatter;

class Order extends Model
{
    protected $guarded = [];
    public $subtotal;
    public $paymentStatus;

    /**
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity', 'unit_price');
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getFormattedSubtotal(): string
    {
        return $this->formattedPrice($this->getSubtotal());
    }

    /**
     * @return float|int
     */
    public function getSubtotal()
    {
        $subtotal = 0.0;
        foreach ($this->books as $book) {
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

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return string
     */
    public function paymentStatus(): string
    {
        $lastTransaction = $this->transactions->sortByDesc('id')->first();
        if (isset($lastTransaction['status'])) {
            return $lastTransaction['status'];
        } else {
            return '(No transaction)';
        }
    }

    /**
     * @return bool
     */
    public function retryPayment(): bool
    {
        return ($this->paymentStatus() === 'REJECTED') ?: false;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return 'APPROVED' == $this->paymentStatus();
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return 'PENDING' == $this->paymentStatus();
    }
}
