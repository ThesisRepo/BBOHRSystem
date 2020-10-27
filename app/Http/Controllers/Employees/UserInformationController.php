<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\UserEloquent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class UserInformationController extends Controller
{

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
        return $this->user->findWith($id, 'userInformation.department','userInformation.shift_time');
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
        
        return response()->json($this->user->updateWithUserInfo($data, $id), 200);        
    }
    public function updateProfileImg($id,Request $request){
        $currentImg = $this->user->findWith($id, 'userInformation')->userInformation->profile_url;
        if($request->image) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'),$imageName);
            $image = 'images/'.$imageName;
            $data = [
                'profile_url' => $image
            ];
            $result = $this->user->updateWithUserInfo($data, $id);
            unlink($currentImg);
            
            return response()->json($result, 200);

        }else {
            return response()->json([], 404);
        }
    }

    public function getAllPrp($id) {

        $user = $this->user->findWith($id, ['userInformation','roles']);
        $max_role = $this->user_service->getMaxRoles($user->roles);
        if($max_role == 1){
            $res = response()->json($this->user->getPrp($user)->toArray(), 200);
        }else {
            $res = response()->json($this->user->getHR()->toArray(), 200);
        }
        return $res;
    }
    
    public function getAllFinance() {

        $res = response()->json($this->user->getFinance()->toArray(), 200);
        
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
}
