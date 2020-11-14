<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\Requests\EloquentRequestImplementation;

class RequestBaseController extends Controller
{

    private $model;
    
    public function __construct(
        EloquentRequestImplementation $model
    ) {
        $this->middleware(['auth', 'verify.manager.hr']);  
        $this->model = $model;
    }

    public function getRequestSummaryByDate($status_id, $start_date, $end_date) {
        $res = $this->model->getRequestSummaryByDate($status_id, $start_date, $end_date);
        return $res;
    }
}
