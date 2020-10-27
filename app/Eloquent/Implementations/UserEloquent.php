<?php

namespace App\Eloquent\Implementations;

use App\Models\User;  
use DB;

class UserEloquent extends EloquentImplementation {  

    public function __construct(User $user) {
      parent::__construct($user);
    }

    public function isRoleExisting($id) {
      return DB::table('role_users')->where('role_id', $id)->count();
    }

    public function createWithRoles($data, array $id) {
      return $this->model->create($data)->roles()->attach($id);
    }
    
    public function updateWithUserInfo($data, $id){
       return  $this->model->findorFail($id)->userInformation()->update($data);
    }

    public function getPrp($user) {

      $res = $this->model->where('id','!=',$user->id)
      ->whereHas('roles', function($q){
        $q->whereIn('role_id', [2]);
      })
      ->whereHas('userInformation', function($q) use($user){
        $q->where('department_id', $user->userInformation->department_id);
      })
      ->get();

      return $res;

    }

    public function getHR() {
      
      $res = $this->model->whereHas('roles', function($q){
        $q->whereIn('role_id', [4]);
      })->get();
      
      return $res;

    }

    public function getFinance() {
      
      $res = $this->model->whereHas('roles', function($q){
        $q->whereIn('role_id', [3]);
      })->get();

      return $res;

    }

  public function getAllFeedbackedRequests($user_id, $relationship) {

    return $this->findWith($user_id, $relationship);

  }

  // get all approved requests for prp

  public function getAllApprovedRequest($user_id, $relationship, $isFinal = false) {
    
    if($isFinal) {

      return $this->getFeedbackRequest($user_id, $relationship, 2);

    }

    return $this->getFeedbackRequest($user_id, $relationship, 0);

  }

  // get all disapproved requests for prp


  public function getAllDisapprovedRequest($user_id, $relationship) {

    return $this->getFeedbackRequest($user_id, $relationship, 3);

  }

  public function getFeedbackRequest($user_id, $relationship, $status_id) {
    return $this->findWith($user_id, [
      $relationship => function($q) use($status_id){
        $q->where('status_id', $status_id);
      }
    ]);
  }

}