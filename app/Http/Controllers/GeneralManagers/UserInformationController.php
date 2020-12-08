<?php

namespace App\Http\Controllers\GeneralManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Eloquent\Implementations\UserEloquent;
use App\Services\AllUserRequestsService;

class UserInformationController extends Controller
{
    protected $user;

    protected $user_service;
    protected $all_user_request_service;

    public function __construct(
            UserEloquent $user,
            UserService $user_service,
            AllUserRequestsService $all_user_request_service
        ) {
        $this->middleware(['auth', 'verify.manager.general']);  
        $this->user = $user;
        $this->user_service = $user_service;
        $this->all_user_request_service = $all_user_request_service;
    }

    public function getAllPendingRequests($id) {
        $with = ['user.userInformation', 'user.userInformation.company_positions', 'user.userInformation.department'];
        $res = $this->all_user_request_service->getGMAllToApprove($with);
        return $res;
    }
}
