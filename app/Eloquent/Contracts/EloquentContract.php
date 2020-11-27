<?php

namespace App\Eloquent\Contracts;

interface EloquentContract {
  /**
   * retrieves all info from db
   */
  public function all();

  /**
   * @param array $data
   * populates db
   */
  public function create(array $data);

  /**
   * @param int $id
   * finds data for matching id in db
   */
  public function find($id);

  public function count();

  public function findOrFail( $id);

  public function findWith( $id, $relationship);

  /**
   * @param array $data
   * @param int $id
   * updates data for matching id in db
   */
  public function update(array $data, $id);

  /**
   * @param int $id
   * deletes data for matching id in db
   */
  public function deleteWhere($column, $id);

  public function setModel( $model);

} 