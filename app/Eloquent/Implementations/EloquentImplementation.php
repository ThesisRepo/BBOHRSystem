<?php

namespace App\Eloquent\Implementations;
use App\Eloquent\Contracts\EloquentContract;
use Illuminate\Database\Eloquent\Model;

class EloquentImplementation implements EloquentContract {

  /**
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $model;

  /**
   * @param Model
   * called during instantiation
   * 
   * @return void
   */
  public function __construct( Model $model) {
    $this->model = $model;
  }

  /**
   * @param array $data
   * 
   * populates db
   */
  public function create( array $data) {
    $this->model->create($data);
  }
  
  /**
   * @param string $model
   * creates a model
   * 
   * @return App\Eloquent\Implementations\EloquentImplementation
   */
  public function setModel( $model) {
    $this->model = $model;
    return $this;
  }

  /**
   * @param string $relationship
   * creates a relationship
   * 
   * @return App\Eloquent\Implementations\EloquentImplementation
   */
  public function with( $relationship) {

    return $this->model->with( $relationship);
  }
}