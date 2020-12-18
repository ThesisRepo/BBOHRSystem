<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AllUserRequestsService;

class RequestsController extends Controller
{

    protected $all_user_request_service;

    public function __construct(
        AllUserRequestsService $all_user_request_service

    ) {
        $this->middleware(['auth', 'verify.admin']);  
        $this->all_user_request_service = $all_user_request_service;
    }

    public function all() {
        $with = ['user.userInformation', 'user.userInformation.company_positions', 'user.userInformation.department', 'approver_role', 'status'];
        $res = $this->all_user_request_service->getAllPending($with);
        return $res;
    }

    public function getAllPendingLeaveRequest() {
        $with =  ['leave_type', 'status','approver_role', 'user'];
        $table_name = 'leave_requests';
        $res = $this->all_user_request_service->getAllPendingPerRequest($table_name, 1, $with);
        return $res;
    }
}
