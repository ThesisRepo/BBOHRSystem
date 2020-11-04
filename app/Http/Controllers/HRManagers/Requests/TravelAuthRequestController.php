<?php

namespace App\Http\Controllers\HRManagers\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;

class TravelAuthRequestController extends RequestBaseController
{
    public function __construct(
        TravelAuthRequestEloquent $travel_auth_request
    ) {
        parent::__construct($travel_auth_request);
    }

    public function getApprovedLeaveRequestSummary(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status_id = 2;
        $res = $this->getRequestSummaryByDate($status_id, $start_date, $end_date);
        return $res;
    }
}
