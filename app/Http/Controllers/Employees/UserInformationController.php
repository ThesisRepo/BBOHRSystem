<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\UserEloquent;
use App\Http\Controllers\Controller;

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
        
        return $this->user->updateWithUserInfo($data, $id);        
    }

    
}
