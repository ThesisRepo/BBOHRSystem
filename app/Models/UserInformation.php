<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{

    protected $table = 'user_informations';
    /**
     * attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'company_number',
        'profile_url',
        'position',
        'date_hired',
        'contact_number',
        'status',
        'birthday',
        'address',
        'tin_number',
        'sss_number',
        'pag_ibig_number',
        'philhealth_number',
        'allowed_leave_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship of user information to its user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user() {
        return belongsTo(User::class);
    }

    /**
     * Relationship of user information to its department
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function department() {
        return belongsTo(Department::class);
    }


}
