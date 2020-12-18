<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class TravelAuthRequest extends Model
{
  protected $fillable = [
    'user_id',
    'destination',
    'start_date',
    'end_date',
    'emergency_contact',
    'contact_number',
    'employee_to_cover_id',
    'file_uri',
    'approver_role_id',
    'status_id'
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
  //   return $this->morphToMany(\App\Models\User::class, 'requestable')->withTimestamps();        
  // }

  public function approver_role() {
      return $this->belongsTo(\App\Models\Role::class);
  }

  public function employee_to_cover() {
    return $this->belongsTo(\App\Models\User::class, 'employee_to_cover_id');
  }

  public function overriden_requests()
  {
      return $this->morphMany(\App\Models\OverridenRequest::class, 'overriden_requestable');
  }

}
