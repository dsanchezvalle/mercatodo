<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    protected $guarded = [];

    public function isActive(): string
    {
        if($this->is_active){
            return 'Yes';
        }
        return 'No';
    }

    /**
     * @param Builder $query
     * @param string|null $author
     * @return Builder
     */
    public function scopeAuthor(Builder $query, ? string $author): Builder
    {
        if(null !== $author){
            return $this->searchByField($query, 'author', "%$author%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $title
     * @return Builder
     */
    public function scopeTitle(Builder $query, ? string $title): Builder
    {
        if(null !== $title){
            return $this->searchByField($query, 'title', "%$title%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $isbn
     * @return Builder
     */
    public function scopeIsbn(Builder $query, ? string $isbn): Builder
    {
        if(null !== $isbn){
            return $this->searchByField($query, 'isbn', "$isbn");
        }

        return $query;
    }


    /**
     * @param Builder $query
     * @param string $field
     * @param string $value
     * @return Builder
     */
    private function searchByField (Builder $query, string $field, string $value): Builder
    {
        //dd($field);
        return $query->where($field, 'like', $value);
    }
}
