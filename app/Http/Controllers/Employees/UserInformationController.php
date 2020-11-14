<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\UserEloquent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ImageUpload;

class UserInformationController extends Controller
{
    use ImageUpload;
    
    protected $user;

    protected $user_service;

    public function __construct(
            UserEloquent $user,
            UserService $user_service
        ) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->user = $user;
        $this->user_service = $user_service;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = $this->user->findWith($id, 'userInformation.department','userInformation.shift_time');
        return $res;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = [
            'address'=> $request->address,
            'civil_status'=> $request->civil_status,
            'contact_number'=> $request->contact_number,
            'pag_ibig_number'=> $request->pag_ibig_number,
            'sss_number'=> $request->sss_number,
            'tin_number'=> $request->tin_number,
            'philhealth_number'=> $request->philhealth_number
        ];
        
        $res = response()->json($this->user->updateWithUserInfo($data, $id), 200);    
        
        return $res;

    }
    public function updateProfileImg($id,Request $request){

        $currentImg = $this->user->findWith($id, 'userInformation')->userInformation->profile_url;
        if($request->image) {

            $image = $this->image_upload_from_trait($request->image);

            // $imageName = time().'.'.$request->image->getClientOriginalExtension();
            // $request->image->move(public_path('images'),$imageName);
            // $image = 'images/'.$imageName;

            $data = [
                'profile_url' => $image
            ];

            $result = $this->user->updateWithUserInfo($data, $id);
            unlink($currentImg);
            
            $res = response()->json($result, 200);

        }else {
            $res = response()->json([], 404);
        }

        return $res;

    }

    public function getAllPrpInDepartment($id) {

        $user = $this->user->findWith($id, ['userInformation','roles']);
        $max_role = $this->user_service->getMaxRoles($user->roles);
        if($max_role == 1){
            $res = response()->json($this->user->getPrp($user)->toArray(), 200);
        }else {
            $res = response()->json($this->user->getHR()->toArray(), 200);
        }

        return $res;
    }

    public function getAllPrp() {
        $res = $this->user->getAllPrp();
        return $res;
    }

    public function getAllFinance() {

        $res = response()->json($this->user->getFinance()->toArray(), 200);
        
        return $res;
    }

    public function getAllCoEmployeesInDepartment(){

        $user_id = $this->user_service->getAuth()->id;
        $department_id = $this->user_service->getAuth()->load('userInformation')->userInformation->department_id;
        $column = 'id';
        $operator = '!=';
        $value = $user_id;
        $relationship = 'userInformation';
        $relationship_column = 'department_id';
        $relationship_value = $department_id;
        $relationship_operator = '=';
        $res = $this->user->whereWithWhereHas($column, $operator, $value, $relationship, $relationship_column, $relationship_operator, $relationship_value);
        
        return $res;

    }

    public function updatePrp($user_id, Request $request) {

        $data = [
            'prp_assigned'=> $request->prp_assigned_id
        ];
        $res = response()->json($this->user->find($user_id)->update($data), 200);

        return  $res;
    }

    public function updateFinance($user_id, Request $request) { 

        $data = [
            'finance_mngr_assigned'=> $request->finance_mngr_assigned
        ];
        $res = response()->json($this->user->find($user_id)->update($data), 200);

        return  $res;
    }

    public function getAllPendingRequests($id) {
        $res = $this->user->getAllPendingRequests($id);
        return $res;
    }

    public function getCountApprovedRequests($id) {
        $res = $this->user->getCountOfRequests($id, 3);
        return $res;
    }

    public function getCountPendingRequests($id) {
        $res = $this->user->getCountOfRequests($id, 1);
        return $res;
    }
}
