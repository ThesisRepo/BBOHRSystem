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
      $res = $this->model->create($data);
      $res->roles()->attach($id);
      return $res;
    }
    
    public function updateWithUserInfo($data, $id){
       return  $this->model->findorFail($id)->userInformation()->updateOrCreate(['user_id' => $id], $data);
    }

    public function allWith($relationship){
      return  $this->with($relationship)->get();
   }
    public function updateUserWithInfo($id, $user, $user_info, $company_position){
      // dd($user_info, $company_position); 
      // dd('hi');
      $company_position = [

      ];
      $user_in = [
        'department_id' => $user_info['department_id']['id'],
        'shift_time_id'=> $user_info['shift_time_id'],
        'gender' => $user_info['gender'],
        'company_number'  => $user_info['company_number'],
        'date_hired'  =>  $user_info['date_hired'],
        'contact_number'  => $user_info['contact_number'],
        'civil_status_id'  => $user_info['civil_status_id'],
        'company_status_id'  => $user_info['company_status']['id'],
        'regularization_date'  => $user_info['regularization_date'],
        'birthday'  => $user_info['birthday'],
        'address'  => $user_info['address'],
        'allowed_leave_number' => $user_info['allowed_leave_number'],
      ];
      // dd($user_info);
      try {
        DB::beginTransaction();
          $res = $this->model->findorFail($id);
          $res->update($user);
          $res->userInformation()->update($user_in);
          // $res->userInformation->company_positions()->attach($company_position);
        DB::commit();
        dd($res);
        return $res;
      }catch(\Exception $e) {
        DB::rollback();
        return $e;
      }

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

    public function getAllPrp() {
      $res = $this->model->whereDoesntHave('roles', function($q){
        $q->whereIn('role_id', [3, 5]);
      })->whereHas('roles', function($q){
        $q->whereIn('role_id', [2]);
      })->get();
    
      return $res;

    }

    public function getHR() {
      
      $res = $this->model->whereHas('roles', function($q){
        $q->whereIn('role_id', [4]);
      })->get();
      
      return $res;

    }

    public function getGenMngr() {
      
      $res = $this->model->whereHas('roles', function($q){
        $q->whereIn('role_id', [5]);
      })->get();
      
      return $res;

    }

    public function getAllNonAdminEmployees() {
      
      $res = $this->model->with(['userInformation', 'userInformation.department', 'userInformation.company_status', 'assignedPrp', 'assignedFinance', 'roles', 'userInformation.company_positions'])->whereDoesntHave('roles', function($q){
        $q->whereIn('role_id', [3, 4, 5]);
      })->get();
      
      return $res;

    }

    public function getFinance() {
      
      $res = $this->model->with(['assignedFinance'])->whereHas('roles', function($q){
        $q->whereIn('role_id', [3]);
      })->get();

      return $res;

    }

  public function getAllFeedbackedRequests($user_id, $relationship, $nested_relationship, $order_by = 'DESC') {
    $res = $this->findWith(
      $user_id,
      [
        $relationship => function($q) use($nested_relationship, $order_by ){
          return $q->with($nested_relationship)->orderBy('updated_at', $order_by);
        }
      ] 
    );
    
    return $res;

  }

  // get all approved requests for prp

  public function getAllApprovedRequest($user_id, $relationship, $isFinal = false) {

    if($isFinal) {

      return $this->getFeedbackRequest($user_id, $relationship, 2);

    }

    return $this->getFeedbackRequest($user_id, $relationship, 1);

  }

  // get all disapproved requests for prp


  public function getAllDisapprovedRequest($user_id, $relationship) {

    return $this->getFeedbackRequest($user_id, $relationship, 3);

  }

  public function getFeedbackRequest($user_id, $relationship, $status_id) {
    return $this->findWith($user_id, [
      $relationship => function($q) use($status_id){
        return $q->where('status_id', $status_id);
      }
    ]);
  }

  public function getAllPendingRequests($id) {
    $temp_arr = [];
    $request_type_list = [
      'travel_auth_requests',
      'leave_requests',
      'shift_change_requests',
      'overtime_requests',
      'petty_cash_requests',
      'budget_requests'
    ];
    $with= ['approver_role', 'status'];
    $relationship = [
      'travel_auth_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      }, 
      'leave_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      },
      'shift_change_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      },
      'overtime_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      },
      'petty_cash_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      },
      'budget_requests' => function($q) use( $with){
          return $q->with($with)->where('status_id', 1);
      }
    ];
    // if($clause) {
    //   $relationship = [ 
    //     'leave_requests' => function($q) use( $with, $clause){
    //         return $q->where('status_id', 1);
    //     }
    //   ];
      // dd($relationship);
    // }
    $res = $this->findWith( $id, $relationship);
    // dd($res->toArray());
    foreach($request_type_list as $request_type) {
      $request_array = $res[$request_type]->toArray();
      if(!empty($request_array)) {
        foreach($request_array as $request) {
          $new_request = [
            'request_type' => $request_type,
            'status' => $request['status'],
            'approver_role' => $request['approver_role'],
            'created_at' => $request['created_at']
          ];
          array_push($temp_arr, $new_request);
        }
      }
    };
    return $temp_arr;
  }
  // public function getGMAllPendingRequests($id, $with) {
  //   $temp_arr = [];
  //   $request_type_list = [
  //     'travel_auth_requests',
  //     'leave_requests',
  //     'shift_change_requests',
  //     'overtime_requests',
  //     'petty_cash_requests',
  //     'budget_requests'
  //   ];
  //   $with= ['approver_role', 'status'];
  //   $relationship = [
  //     'travel_auth_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     }, 
  //     'leave_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     },
  //     'shift_change_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     },
  //     'overtime_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     },
  //     'petty_cash_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     },
  //     'budget_requests' => function($q) use( $with){
  //         return $q->with($with)->where('status_id', 1)->where('approver_role_id', 5);
  //     }
  //   ];
  //   $res = $this->find($id);
  //   dd($res);
  //   foreach($request_type_list as $request_type) {
  //     $request_array = $res[$request_type]->toArray();
  //     if(!empty($request_array)) {
  //       foreach($request_array as $request) {
  //         $new_request = [
  //           'request_type' => $request_type,
  //           'status' => $request['status'],
  //           'approver_role' => $request['approver_role'],
  //           'created_at' => $request['created_at']
  //         ];
  //         array_push($temp_arr, $new_request);
  //       }
  //     }
  //   };
  //   return $temp_arr;
  // }
  public function getCountOfRequests($id, $type_id) {
    $res = 0;
    $request_type_list = [
      'travel_auth_requests_count',
      'leave_requests_count',
      'shift_change_requests_count',
      'overtime_requests_count',
      'petty_cash_requests_count',
      'budget_requests_count'
    ];

    $query = $this->findWithCount(
      $id,
      [
        'travel_auth_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        }, 
        'leave_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        },
        'shift_change_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        },
        'overtime_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        },
        'petty_cash_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        },
        'budget_requests' => function($q) use($type_id){
          return $q->with(['approver_role', 'status'])->where('status_id', $type_id);
        }
      ]
    );

    foreach($request_type_list as $request_type) {
        $request_count = $query[$request_type];
        $res +=  $request_count;
    }
    return $res;

  }

  public function registerUser($user, $roles, $user_info, $company_position) {

    try {
      DB::beginTransaction();
        $user = $this->model->create($user);
        $user->roles()->attach($roles);
        $user->userInformation()->create($user_info);
        $user->userInformation->company_positions()->attach([$company_position]);
      DB::commit();
      return $user->load(['roles', 'userInformation']);
    }catch(\Exception $e) {
      DB::rollback();
      throw new \ErrorException($e);
      // return $e;
    }
    
  }

  public function getRequestFeedbackedSelective($user_id, $relationship, $status_array) {

    $new_relationship = [
        $relationship => function( $q) use( $status_array) {
          return $q->whereIn('status_id', $status_array);
        }
      ];
    $res = $this->findWith($user_id, $new_relationship);

    return $res;

  }

  public function getRequestFeedbackedDate($user_id, $table_name, $relationship, $start_date, $end_date, $status= 2, $order_by = "DESC") { 
    $new_relationship = [
      $relationship => function( $q) use( $table_name, $start_date, $end_date, $status, $order_by) {
        return $q->whereDate( $table_name . '.created_at','>=', $start_date)
          ->whereDate( $table_name . '.created_at','<=', $end_date)
          ->where('status_id', $status)
          ->orderBy( $table_name . '.created_at', $order_by);
      },
      $relationship . '.' . 'user',
      $relationship . '.' . 'status'  
    ];
    if($relationship == 'feedbacked_leave_requests') {
      array_push( $new_relationship, $relationship . '.' . 'leave_type' );
    }
    $res = $this->findWith( $user_id, $new_relationship);
    // dd();
    return $res;

  }

  public function getTableFeedbackedLeaveRequests() {
    $res = $this->model->feedbacked_leave_requests()->getTable();
    return $res;
  }

  public function getTableFeedbackedOvertimeRequests() {
    $res = $this->model->feedbacked_overtime_requests()->getTable();
    return $res;
  }

  public function getTableFeedbackedPettyCashRequests() {
    $res = $this->model->feedbacked_petty_cash_requests()->getTable();
    return $res;
  }

  public function getTableFeedbackedBudgetRequests() {
    $res = $this->model->feedbacked_budget_requests()->getTable();
    return $res;
  }

  public function getTableFeedbackedTravelAuthRequests() {
    $res = $this->model->feedbacked_travel_auth_requests()->getTable();
    return $res;
  }

  public function getTableFeedbackedShiftChangeRequests() {
    $res = $this->model->feedbacked_shift_change_requests()->getTable();
    return $res;
  }
}