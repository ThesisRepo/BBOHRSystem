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

  public function createRequest( array $data, $prp_assigned_id) {
  try {
    DB::beginTransaction();
    User::find($data->user_id)->update(['prp_assigned'=> $prp_assigned_id]);
    parent::create($data);
    DB::commit();
  } catch (\Exception $e) {
    DB::rollback();
  }
    return $this->model->create($data);
  }
  public function updateRequest(array $data, $id, $prp_assigned_id){
    try {
      DB::beginTransaction();
      $user_id = parent::findWith($id, 'user')->user->id;
      User::find($user_id)->update(['prp_assigned'=>$prp_assigned_id]);
      parent::update($data, $id);
      DB::commit();
    } catch (\Exception $e) {
      dd($e);
      DB::rollback();
    }
  }
}