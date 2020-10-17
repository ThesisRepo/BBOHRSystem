<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    /**
     * Attribute that is mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'status_name'
    ];
    
    public function leave_requests() {
        return $this->hasMany(LeaveRequest::class);
    }
}
