<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class PettyCashRequest extends Model
{
    protected $fillable = [ 
        'user_id',
        'description_need',
        'date',
        'total_amount',
        'approver_role_id',
        'status_id',
        'department_id'
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function approvers() {
        return $this->morphToMany(\App\Models\User::class, 'recordable')->withTimestamps();
    }

    // public function user_requester() {
    //     return $this->morphToMany(\App\Models\User::class, 'requestable')->withTimestamps();        
    // }
    
    public function approver_role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function department() {
        return $this->belongsTo(\App\Models\Department::class);
    }

    public function overriden_requests()
    {
        return $this->morphMany(\App\Models\OverridenRequest::class, 'overriden_requestable');
    }
}
