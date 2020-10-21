<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\BudgetRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;

class BudgetRequestController extends RequestBaseController
{
    protected $budget_request;

    public function __construct(
        BudgetRequestEloquent $budget_request,
        RoleEloquent $role,
        UserEloquent $user
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->budget_request = $budget_request;
        parent::__construct($role ,$user, $budget_request);
        parent::setRequestName('budget_request');
    }

    public function show( $id) {
        return $this->showRequest('user_id', $id, ['approver_role', 'status', 'user.userInformation']);
    }
    
    public function store(Request $request) {
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'description_need'=> $request->description_need,
            'date'=> $request->date,
            'total_amount'=> $request->total_amount,
            'details'=> $request->details,
            'department_id' => $this->findDepartment($request->user_id),
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];
        return $this->storeRequest($requestData, $prp_assigned_id);
    }
    
    public function update(Request $request, $id) {

        $current_budget_request = $this->budget_request->find($id);
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'description_need'=> $request->description_need,
            'date'=> $request->date,
            'total_amount'=> $request->total_amount,
            'details'=> $request->details
        ];
        return $this->updateRequest($current_budget_request, $requestData, $id, $prp_assigned_id);
    }

    public function delete( $id) {
        return $this->deleteRequest($id);
    }
}
