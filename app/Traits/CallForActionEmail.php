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
    $job = (new UserAccRegister($data, $user))->delay(Carbon::now()->addSeconds(1250));
    dispatch($job);
  }

}