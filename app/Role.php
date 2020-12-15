<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    /**
     * @return HasMany
     */

    public function user()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return Collection
     */
    public static function getCachedRoles(): Collection
    {

        return Cache::rememberForever('roles', function(){
            return Role::select('id','name')->orderBy('id')->get();
        });
    }
}
