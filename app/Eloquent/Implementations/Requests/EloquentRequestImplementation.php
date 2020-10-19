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
}