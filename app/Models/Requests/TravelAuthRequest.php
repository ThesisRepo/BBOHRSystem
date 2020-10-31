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
    'employee_to_cover',
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
      return $this->morphToMany(\App\Models\User::class, 'approved_request_records');
  }

  public function request() {
    return $this->morphMany(\App\Models\Requestable::class, 'requestable')->withTimestamps();
  }

  public function approver_role() {
      return $this->belongsTo(\App\Models\Role::class);
  }
}
