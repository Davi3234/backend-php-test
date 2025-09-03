<?php

namespace Core\Exception;

use Exception;

class HttpException extends Exception{
  private array $errors;
  public function __construct(int $code = 0, array $errors = []){
    parent::__construct('', $code);
    $this->errors = $errors;
  }
  public function getErrors(){
    return $this->errors;
  }
}