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
    public static function scopeAuthor(Builder $query, ? string $author): Builder
    {
        if(null !== $author){
            return $query->where('author', 'like', "%$author%");
        }

        return $query;
    }
}
