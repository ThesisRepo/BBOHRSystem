<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;

class TravelAuthRequestController extends RequestBaseController
{
    protected $travel_auth_request;

    public function __construct(
        TravelAuthRequestEloquent $travel_auth_request,
        RoleEloquent $role,
        UserEloquent $user
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->travel_auth_request = $travel_auth_request;
        parent::__construct($role ,$user, $travel_auth_request);
        parent::setRequestName('travel_auth_request');
    }

    public function show( $id) {
        return $this->showRequest('user_id', $id, ['approver_role', 'status', 'user.userInformation']);
    }
    
    public function store(Request $request) {
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'destination'=> $request->destination,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'details'=> $request->details,
            'emergency_contact'=> $request->emergency_contact,
            'employee_to_cover'=> $request->employee_to_cover,
            'file_uri'=> $request->file_uri,
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];
        return $this->storeRequest($requestData, $prp_assigned_id);
    }
    
    public function update(Request $request, $id) {

        $current_travel_auth_request = $this->travel_auth_request->find($id);
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'destination'=> $request->destination,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'details'=> $request->details,
            'emergency_contact'=> $request->emergency_contact,
            'employee_to_cover'=> $request->employee_to_cover,
            'file_uri'=> $request->file_uri,
        ];
        return $this->updateRequest($current_travel_auth_request, $requestData, $id, $prp_assigned_id);
    }

    public function delete( $id) {
        return $this->deleteRequest($id);
    }
}