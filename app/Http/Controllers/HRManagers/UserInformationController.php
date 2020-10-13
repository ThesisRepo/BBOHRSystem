<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInformationController extends Controller
{

    protected $user;

    public function __construct(UserEloquent $user) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->all();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->user->create($request->all());
    }
    
    public function update(Request $request, $id)
    {
        return $this->user->updateWithUserInfo($request->all(), $id);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);
    }
}
