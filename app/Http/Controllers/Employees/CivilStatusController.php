<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CivilStatusEloquent;

class CivilStatusController extends Controller
{
    protected $civil_status;

    public function __construct(
        CivilStatusEloquent $civil_status
    ) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->civil_status = $civil_status;
    }

    public function index() {
        $res = $this->civil_status->all();
        return $res;
    }

    public function showNotMine($id) {
        $res = $this->civil_status->whereNative('id', '!=', $id);
        return $res;
    }

}
