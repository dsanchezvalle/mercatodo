<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Book extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'unit_price');
    }

    /**
     * @return string
     */
    public function isActive(): string
    {
        if ($this->is_active) {
            return 'Yes';
        }
        return 'No';
    }

    /**
     * @param  Builder     $query
     * @param  string|null $author
     * @return Builder
     */
    public function scopeAuthor(Builder $query, ?string $author): Builder
    {
        if (null !== $author) {
            return $this->searchByField($query, 'author', "%$author%", 'like');
        }

        return $query;
    }

    /**
     * @param  Builder     $query
     * @param  string|null $title
     * @return Builder
     */
    public function scopeTitle(Builder $query, ?string $title): Builder
    {
        if (null !== $title) {
            return $this->searchByField($query, 'title', "%$title%", 'like');
        }

        return $query;
    }

    /**
     * @param  Builder     $query
     * @param  string|null $isbn
     * @return Builder
     */
    public function scopeIsbn(Builder $query, ?string $isbn): Builder
    {
        if (null !== $isbn) {
            return $this->searchByField($query, 'isbn', "$isbn");
        }

        return $query;
    }

    /**
     * @param  Builder     $query
     * @param  string|null $status
     * @return Builder
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ("true" == $status) {
            return $this->searchByField($query, 'is_active', true);
        } elseif ("false" == $status) {
            return $this->searchByField($query, 'is_active', false);
        }

        return $query;
    }


    /**
     * @param  Builder     $query
     * @param  string      $field
     * @param  string      $value
     * @param  string|null $operator
     * @return Builder
     */
    private function searchByField(Builder $query, string $field, string $value, string $operator = '='): Builder
    {
        return $query->where($field, $operator, $value);
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
