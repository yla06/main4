<?php
namespace MyException;

class BaseException
{
  public function __construct()
  {
    echo '<pre>';
    print_r( __CLASS__ );
    echo '</pre>';
  }
}