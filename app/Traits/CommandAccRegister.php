<?php
namespace App\Traits;
use  App\Traits\CallForActionEmail;

trait CommandAccRegister
{
  use CallForActionEmail;

  private $model;

  public function setModel($model) {
    $this->model = $model;
  }

  public function createSuperAdmin($type, $firstname, $lastname, $email, $pwd) {
    $res = $this->model->createWithRoles([
        'first_name' => $firstname,
        'last_name' => $lastname,
        'email' => $email,
        'password' => bcrypt($pwd),
    ], $type);
    $this->sendVerificationEmailOnRegister($res);
  }
  
}