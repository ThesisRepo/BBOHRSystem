<?php

namespace App\Eloquent\Contracts;

interface EloquentContract {
  
  public function all();

  /**
   * @param array $data
   * populates db
   */
  public function create(array $data);

} 