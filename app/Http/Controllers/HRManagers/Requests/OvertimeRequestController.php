<?php

namespace App\Http\Controllers\HRManagers\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;

class OvertimeRequestController extends RequestBaseController
{

    public function __construct(
        OvertimeRequestEloquent $overtime_request
    ) {
        parent::__construct($overtime_request);
    }

    public function getApprovedLeaveRequestSummary(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status_id = 2;
        $res = $this->getRequestSummaryByDate($status_id, $start_date, $end_date);
        return $res;
    }
}
