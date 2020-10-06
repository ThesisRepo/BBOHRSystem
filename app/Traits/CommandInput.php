<?php
namespace App\Traits;

trait CommandInput {

  /**
   * 
   * @var string
   */
  private $firstname;

  /**
   * 
   * @var string
   */
  private $lastname;

  /**
   * 
   * @var string
   */
  private $email;

  /**
   * password
   * 
   * @var string
   */
  private $pwd;

  /**
   * set the private values.
   * 
   * @return void 
   */
  public function setRegisterValues() 
  {

    $this->firstname = $this->askValid('enter Firstname?', 'firstname', ['required']);
    $this->lastname = $this->askValid('enter Lastname?', 'lastname', ['required']);
    $this->email = $this->askValid('enter email?', 'email', ['required', 'email']);
    $this->pwd = $this->askValid('enter password', 'password', ['required', 'min:8'], true);
  }
}