<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    /**
     * Attribute that is mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'leave_name'
    ];
    public function leave_request() {
        return $this->hasMany(LeaveRequest::class);
    }
}
