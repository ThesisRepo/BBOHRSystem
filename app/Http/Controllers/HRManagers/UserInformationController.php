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

}
