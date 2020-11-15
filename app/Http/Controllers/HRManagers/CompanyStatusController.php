<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CompanyStatusEloquent;

class CompanyStatusController extends Controller
{
    protected $company_status;

    public function __construct(
        CompanyStatusEloquent $company_status
        ) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->company_status = $company_status;
    }

    public function index() {
        $res = $this->company_status->all();
        return $res;
    }
}
