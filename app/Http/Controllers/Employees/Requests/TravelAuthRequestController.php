<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Traits\ImageUpload;

class TravelAuthRequestController extends RequestBaseController
{

    use ImageUpload;
    protected $travel_auth_request;

    public function __construct(
        TravelAuthRequestEloquent $travel_auth_request,
        RoleEloquent $role,
        UserEloquent $user,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->travel_auth_request = $travel_auth_request;
        parent::__construct($role ,$user, $travel_auth_request,$user_request_service,$user_service);
        parent::setRequestName('travel_auth_request');
    }

    public function show( $id) {
        $res = $this->showRequest('user_id', $id, ['approver_role', 'status', 'user.userInformation' , 'employee_to_cover']);
        return $res;
    }
    
    public function store(Request $request) {
        $image = $this->image_upload_from_trait($request->file_uri);

        $requestData = [
            'user_id'=> $request->user_id,
            'destination'=> $request->destination,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'emergency_contact'=> $request->emergency_contact,
            'contact_number'=> $request->contact_number,
            'employee_to_cover_id'=> $request->employee_to_cover,
            'file_uri'=> $image,
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];

        // return $this->storeRequest($requestData, $prp_assigned_id);

        $res = $this->storeRequest($requestData);

        return $res;
    }
    
    public function update(Request $request, $id) {

        $current_travel_auth_request = $this->travel_auth_request->find($id);

        // $prp_assigned_id = $request->prp_assigned_id;

        $requestData = [
            'destination'=> $request->destination,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'emergency_contact'=> $request->emergency_contact,
            'contact_number'=> $request->contact_number,
            'employee_to_cover_id'=> $request->employee_to_cover,
            'file_uri'=> $request->file_uri,
        ];

        // return $this->updateRequest($current_travel_auth_request, $requestData, $id, $prp_assigned_id);
        $res = $this->updateRequest($current_travel_auth_request, $requestData, $id);
        return $res;  

    }

    public function delete( $id) {
        $res =  $this->deleteRequest($id);
        return $res;  
    }
}
