<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyStatus extends Model
{
    protected $table = "company_status";
    protected $fillable = [
        'company_status_name'
    ];
    
    // public function users() {
    //     return $this->hasMany()
    // }
}
