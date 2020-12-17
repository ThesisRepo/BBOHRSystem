<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\UserEloquent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Hash;

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
        $res = $this->user->findWith($id, ['userInformation.department', 'userInformation.shift_time', 'userInformation.company_positions']);
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

        $hasUserInfo = $this->user_service->hasUserInformation();
        if($hasUserInfo) {
            $data = [
                'first_name'=> $request->first_name,
                'last_name'=> $request->last_name,

                'address'=> $request->address,
                'civil_status_id'=> $request->civil_status,
                'contact_number'=> $request->contact_number
            ];
        }
        if(!$hasUserInfo) {
            $data = $request->all();
        }
        $res = response()->json($this->updateInfo($data, $id), 200); 
        
        return $res;
    }

    public function updateAdmin(Request $request, $id)
    {
        if (!$this->user->whereNative('id','!=',$id)->where('email', $request->email)->count()) {
            $hasUserInfo = $this->user_service->hasUserInformation();
            if($hasUserInfo) {
                $data = [
                    'first_name'=> $request->first_name,
                    'last_name'=> $request->last_name,
                    'email'=> $request->email,

                    'address'=> $request->address,
                    'civil_status_id'=> $request->civil_status_id,
                    'contact_number'=> $request->contact_number,
                    'pag_ibig_number'=> $request->pag_ibig_number,
                    'sss_number'=> $request->sss_number,

                    'tin_number'=> $request->tin_number,
                    'philhealth_number'=> $request->philhealth_number,
                    'email'=> $request->email,
                    'regularization_date'=> $request->regularization_date,
                    'department_id'=> $request->department_id,
                    'shift_time_id'=> $request->shift_time_id,
                    'gender'=> $request->gender,
                    'date_hired'=> $request->date_hired,
                    'company_status_id'=> $request->company_status_id,
                    'birthday'=> $request->birthday,
                    'company_number'=> $request->company_number
                ];
            }
            if(!$hasUserInfo) {
                $data = $request->all();
            }
            $res = response()->json($this->updateInfo($data, $id), 200);    
        }else {
            $res = response()->json(['message' => 'email address is already taken.'], 422);    
        }
        return $res;

    }
    public function updateInfo($data, $id)
    {
        $res = $this->user->updateWithUserInfo($data, $id);
        return $res;
    }
    
    public function updateProfileImg($id,Request $request){
        $user_info = $this->user->findWith($id, 'userInformation')->userInformation;
        if($user_info) {
            $currentImg = $this->user->findWith($id, 'userInformation')->userInformation->profile_url;
        }
        if($request->image) {

            $image = $this->image_upload_from_trait($request->image);
            // $imageName = time().'.'.$request->image->getClientOriginalExtension();
            // dd($request->image->move(public_path('images'),$imageName));

            // $request->image->move(public_path('images'),$imageName);
            // $image = 'images/'.$imageName;

            $data = [
                'profile_url' => $image
            ]; 
            
            $result = $this->user->updateWithUserInfo($data, $id);
            if($currentImg && file_exists(public_path() . '/' . $currentImg)) {
                unlink(public_path().'/' . $currentImg);
            }
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
        }else if($max_role == 4){
            $res = response()->json($this->user->getGenMngr()->toArray(), 200);
        }
        else {
            // dd('dfd');
            $res = response()->json($this->user->getHR()->toArray(), 200);
        }

        return $res;
    }

    public function getAllPrp() {
        $res = $this->user->getAllPrp();
        return $res;
    }

    public function getAllFinance() {
        $isFinance = false;
        foreach($this->user_service->getAuth()->roles as $role) {
            if($role->id == 3) {
                $isFinance = true;
                break;   
            }
        };
        if(!$isFinance) {
            $res = response()->json($this->user->getFinance()->toArray(), 200);
        } else {
            $res = response()->json($this->user->getGenMngr()->toArray(), 200);            
        }
        return $res;
    }

    public function getAllCoEmployeesInDepartment(){

        $user_id = $this->user_service->getAuth()->id;
        $userInformation = $this->user_service->getAuth()->load('userInformation')->userInformation;
        if($userInformation) {
            $department_id = $userInformation->department_id;
            $column = 'id';
            $operator = '!=';
            $value = $user_id;
            $relationship = 'userInformation';
            $relationship_column = 'department_id';
            $relationship_value = $department_id;
            $relationship_operator = '=';
            $res = $this->user->whereWithWhereHas($column, $operator, $value, $relationship, $relationship_column, $relationship_operator, $relationship_value);
        $status = 200;
        } else {
            $res = ['message'=>'no user information'];
            $status = 422;
        }
       
        return response()->json($res, $status);

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
        $res = $this->user->getCountOfRequests($id, 2);
        return $res;
    }

    public function getCountPendingRequests($id) {
        $res = $this->user->getCountOfRequests($id, 1);
        return $res;
    }

    public function getEventTypes($user_id) {
        $res = $this->user->with('event_types')->find($user_id);
        return $res;
    }
    
    public function addEventTypes(Request $request, $user_id) {
        $data = [
            'event_name' => $request->event_name,
            'color' => $request->color,
        ];
        $res = $this->user->find($user_id)->event_types()->create($data);
        return $res;
    }

    public function updatePassword(Request $request){
        $password = User::firstOrCreate(['id' => $request->id]);
        if(!(Hash::check($request->old_password, $password['password']))){
            return response()->json(['error' => 'Current password is not recognized']);
        }else{
            $password['password'] = Hash::make($request->password);
            $password->save();
            return response()->json(['success' => 'Successfully updated']);
        }
    }

}
