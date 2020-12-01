<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * @return HasMany
     */

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
