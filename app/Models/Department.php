<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'department_name'
    ];

    /**
     * Relationship of department to  user informations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function user_informations(){
        return hasMany(UserInformation::class);
    }
}
