<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
