<?php

trait CommandAccRegister {

  private $model;

  public function setModel($model) {
    $this->model = $model;
  }

  public function createSuperAdmin($type, $firstname, $lastname, $email, $pwd) {
    $this->model->create([
        'role_id' => $type,
        'first_name' => $firstname,
        'last_name' => $lastname,
        'email' => $email,
        'password' => bcrypt($pwd),
    ]);
  }
}