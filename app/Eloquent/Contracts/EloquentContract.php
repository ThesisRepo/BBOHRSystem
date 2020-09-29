<?php

namespace App\Eloquent\Contracts;

interface EloquentContract {
  
  /**
   * @param array $data
   * populates db
   */
  public function create(array $data);
}