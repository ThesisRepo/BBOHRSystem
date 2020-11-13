<?php
namespace App\Traits;
use Mail;
use DB;
use App\Mail\UserAccActivation;
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
    $blade_file = 'emails/user-acc-activation';
    $data = [
      'user' => $activation_data
    ];
    $to = $user_email;
    $subject = 'BBO Request Management Password!';
    $this->emailTemplate($blade_file, $data, $to, $subject);

  }      

  public function emailTemplate($blade_file, $data, $user_data) {
    
    Mail::to($user = $user_data)->send(new UserAccActivation($data));

  }
}