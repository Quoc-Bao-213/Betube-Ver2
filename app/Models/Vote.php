<?php

namespace App\Models;

class Vote extends Model
{
    public function voteable()
    {
        return $this->morphTo();
    }
}
