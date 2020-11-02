<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    public function requestable()
    {
        return $this->morphTo();
    }
}
