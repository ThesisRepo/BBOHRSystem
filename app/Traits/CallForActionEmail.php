<?php
namespace App\Traits;
use App\Jobs\UserAccRegister;
use Carbon\Carbon;
use DB;

trait CallForActionEmail {

  public function sendVerificationEmailOnRegister($user) {
    $user_id = $user['id'];
    $user_email = $user['email'];
    $link = str_random(30);
    $activation_data = [
        'user_id' => $user_id,
        'token' => $link
    ];
    DB::table('user_acc_activations')->insert($activation_data);
    $data = [
      'user' => $activation_data
    ];
    $to = $user_email;
   $this->emailTemplate($data, $user);
  }      

  public function emailTemplate($data, $user) {
    $baseDelay = json_encode(now());
    $getDelay = json_decode(cache('jobs.' . UserAccRegister::class, $baseDelay));
    $setDelay = Carbon::parse(
        $getDelay
    )->addSeconds(5);
    cache([
        'jobs.' . UserAccRegister::class => json_encode($setDelay)
    ], 5);
    $job = new UserAccRegister($data, $user);
    dispatch($job)->delay($setDelay);
  }

}