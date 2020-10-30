<?php

namespace App\Eloquent\Implementations\Requests;
use App\Eloquent\Implementations\EloquentImplementation;  
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DB;

class EloquentRequestImplementation extends EloquentImplementation {

  public function __construct(Model $model) {
    parent::__construct($model);
  }
  public function getModelClass() {
    return get_class($this->model);
  }
  public function createRequest($data, $prp_assigned_id) {
    
    try {
      DB::beginTransaction();
      User::find($data['user_id'])->update(['prp_assigned'=> $prp_assigned_id]);
      $created = parent::create($data);
      DB::commit();
      return $created;
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
    }

  }

  public function updateRequest($data, $id, $prp_assigned_id){

    try {
      DB::beginTransaction();
      $user_id = parent::findWith($id, 'user')->user->id;
      User::find($user_id)->update(['prp_assigned'=>$prp_assigned_id]);
      $created = parent::update($data, $id);
      DB::commit();
      return $created;
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
    }

  }
  
  public function getPendingRequestForApprover($user_id, $max_role_id, $relationship) {
    // ['leave_type', 'status','approver_role', 'user']
    $res = $this->whereWith('status_id',1, $relationship)->where('approver_role_id', $max_role_id)
      ->whereHas('user', function($query) use($user_id){
        return $query->where('prp_assigned',$user_id);
      })->get();
    return $res;

  }

  public function getPendingRequestForApproverAdmin($user_id, $max_role_id, $relationship) {

    $res = $this->whereWith('status_id',1, $relationship)->where('approver_role_id', $max_role_id)
      ->whereHas('user', function($query) use($user_id){
        return $query->where('prp_assigned',$user_id);
      })->orWhereHas('user.assignedPrp.roles', function($query) use($max_role_id) {
        return $query->whereNotIn('role_id',[1,2, $max_role_id]);
      })->get();

    return $res;
    
  }

  public function approveRequest($id, $data, $current_request, $approver) {

        return $this->requestFeedback($id, $data, $current_request, $approver);

  }

  public function disapproveRequest($id, $data, $current_request, $approver) {

    return $this->requestFeedback($id, $data, $current_request, $approver);

  }

  public function requestFeedback($id, $data, $current_request, $approver) {
    
    try {
      DB::beginTransaction();
        $request = $current_request;
        $request->update($data);
        if(!$request->approvers()->where('recordable_id',$id)->where('user_id',$approver->id)->get()->toArray()){
          $request->approvers()->save($approver);
        }
      DB::commit();
      return $request;
    }catch(\Exception $e){
      DB::rollback();
      return $e;
    }
  }

}