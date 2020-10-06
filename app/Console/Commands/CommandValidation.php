<?php

trait CommandValidation {
  
  /**
   * Validates Input.
   * 
   * @param array $rule
   * @param string $fieldName
   * @param string $value
   * 
   * @return Illuminate\Validation\Validator 
   */
  private function validateInput($rules, $fieldName, $value) {
    $validator = Validator::make([
        $fieldName => $value
    ], [
        $fieldName => $rules
    ]);

    return $validator->fails() ? $validator->errors()->first($fieldName) : null;
  }

  /**
   * Continue asking for user input, until conditions are met.
   * 
   * @param string $question 
   * @param string $field 
   * @param array $rule 
   * @param boolean $secret
   * 
   * @return string
   */
  private function askValid($question, $field, $rule, $secret = false) {
    if($secret) {
      $val = $this->secret($question);
    }else {
      $val = $this->ask($question);
    }
    if($message = $this->validateInput($rule, $field, $val)) {
        $this->error($message);
        return $this->askValid($question, $field, $rule, $secret);
    }

    return $val;
  }
}