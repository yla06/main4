<?php
namespace User;

class General
{
  public function checkAuth(  )
  {
    $check = new Auth\CheckAuth;

    echo '<pre>';
    print_r( $check -> check() );
    echo '</pre>';
  }

  public function blogAdd(  )
  {
    $add = new Auth\Blog\Add;
    
  }
}