<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\PettyCashRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;

class PettyCashRequestController extends RequestBaseController
{
    protected $petty_cash_request;

    public function __construct(
        PettyCashRequestEloquent $petty_cash_request,
        RoleEloquent $role,
        UserEloquent $user,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->petty_cash_request = $petty_cash_request;
        parent::__construct($role ,$user, $petty_cash_request, $user_request_service, $user_service);
        parent::setRequestName('petty_cash_request');
    }

    public function show( $id) {
        $res = $this->showRequest('user_id', $id, ['approver_role', 'status', 'user.userInformation', 'department']);
        return $res;
    }
    
    public function store(Request $request) {

        // $prp_assigned_id = $request->prp_assigned_id;

        $requestData = [
            'user_id'=> $request->user_id,
            'description_need'=> $request->description_need,
            'date'=> $request->date,
            'total_amount'=> $request->total_amount,
            'department_id' => $this->findDepartment($request->user_id),
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];

        // return $this->storeRequest($requestData, $prp_assigned_id);

        $res = $this->storeRequest($requestData);

        return $res;

    }
    
    public function update(Request $request, $id) {

        $current_petty_cash_request = $this->petty_cash_request->find($id);

        // $prp_assigned_id = $request->prp_assigned_id;

        $requestData = [
            'description_need'=> $request->description_need,
            'date'=> $request->date,
            'total_amount'=> $request->total_amount
        ];

        // return $this->updateRequest($current_petty_cash_request, $requestData, $id, $prp_assigned_id);

        $res = $this->updateRequest($current_petty_cash_request, $requestData, $id);

        return $res; 

    }

    public function delete( $id) {
        $res =  $this->deleteRequest($id);
        return $res;  
    }
}
