<?php
namespace App\Model;

class BaseModel
{
  public function __construct()
  {
    echo '<pre>';
    print_r( __CLASS__ );
    echo '</pre>';
  }
}