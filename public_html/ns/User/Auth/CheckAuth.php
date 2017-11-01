<?php
namespace User\Auth;

class CheckAuth
{
  public function check()
  {
    return rand( 0, 1 );
  }
}