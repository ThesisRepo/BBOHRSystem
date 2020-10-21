<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\UserEloquent;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserInformationController extends Controller
{

    protected $user;

    public function __construct(UserEloquent $user) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->user = $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->user->findWith($id, 'userInformation.department');
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

    public function getAllPrp() {
        return response()->json($this->user->getPrp()->toArray(), 200); 
    } 
}
