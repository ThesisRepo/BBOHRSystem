<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OverridenRequest extends Model
{
    protected $fillable = [
        'roles_id'
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function overriden_requestable()
    {
        return $this->morphTo();
    }
}
