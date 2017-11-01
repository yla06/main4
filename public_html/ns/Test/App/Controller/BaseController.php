<?php
namespace App\Controller;

class BaseController
{
  public function __construct()
  {
    echo '<pre>';
    print_r( __CLASS__ );
    echo '</pre>';
  }
}