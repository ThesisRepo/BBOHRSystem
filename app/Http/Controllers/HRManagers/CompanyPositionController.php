<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CompanyPositionEloquent;

class CompanyPositionController extends Controller
{
    protected $company_position;

    public function __construct(
        CompanyPositionEloquent $company_position
        ) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->company_position = $company_position;
    }

    public function index() {
        $res = $this->company_position->all();
        return $res;
    }
    
}
