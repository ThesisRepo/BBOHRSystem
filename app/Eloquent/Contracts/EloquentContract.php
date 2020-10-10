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
  public function delete($id);
} 