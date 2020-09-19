<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Attribute that is mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Attribute that is not mass assignable
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users() {
        return $this->hasMany(User::class);
    }
}
