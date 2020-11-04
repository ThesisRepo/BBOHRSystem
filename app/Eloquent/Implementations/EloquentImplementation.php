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

  public function all() {
    return $this->model->all();
  }

  /**
   * @param array $data
   * 
   * populates db
   */
  public function create( array $data) {
    // dd($data);
    return $this->model->create($data);
  }
  /**
   * @param int $id
   * 
   * find the matching value of id
   */
  public function find( $id) {
    return $this->model->find( $id);
  }

  /**
   * @param int $id
   * 
   * find the matching value of id
   */
  public function findOrFail( $id) {
    return $this->model->findOrFail($id);
  }

  public function findWith( $id, $relationship) {
    return $this->model->with( $relationship)->find($id);
  }

  public function findWithCount($id, $relationship) {
    return $this->model->withCount($relationship)->find($id);
  }
  /**
   * @param array $data
   * @param int $id
   * updates data for matching id in db
   */
  public function update(array $data, $id){
    return $this->findOrFail($id)->update($data);
  }

  public function delete($id){
    return $this->findOrFail($id)->delete();
  }
  /**
   * @param int $id
   * deletes data for matching id in db
   */
  public function deleteWhere($column,$id){
    return $this->where($column, $id)->delete();
  }

  public function getWhere($column, $id){
    return $this->where($column, $id)->get();
  }
  
  public function getWhereWith($column, $id, $relationship){
    return $this->with($relationship)->where($column, $id)->get();
  }
  
  public function whereWith($column, $id, $relationship){
    return $this->with($relationship)->where($column, $id);
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

  public function where($column, $id){
    return $this->model->where($column, $id);
  }

  public function whereNative($column, $operator, $id){
    $res = $this->model->where($column, $operator, $id);
    return $res;
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