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
        $this->all_user_request_service = $all_user_request_service;
    }

    public function all() {
        $with = ['user.userInformation', 'user.userInformation.company_positions', 'user.userInformation.department'];
        $res = $this->all_user_request_service->getAllPending($with);
        return $res;
    }
}
