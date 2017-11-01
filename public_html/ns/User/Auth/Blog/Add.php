<?php
namespace User\Auth\Blog;

//\Dir1\Dir2\Dir3\Dir4\Dir5\Dir6 / foo
//\Dir1\Dir2\Dir3\Dir4\Dir5\Dir6 / bar
//\Dir1\Dir2\Dir3\Dir4\Dir5\Dir6 / baz

//use \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\foo;
//use \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\bar;
//use \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\baz;

//use \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\foo,
//    \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\bar,
//    \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\baz;

//use \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6 as lib;

class Add
{
  public function __construct()
  {
//    $check = new \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\foo();
//    $check = new \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\bar();
//    $check = new \Dir1\Dir2\Dir3\Dir4\Dir5\Dir6\baz();
//
//    $check = new lib\foo();
//    $check = new lib\bar();
//    $check = new lib\baz();
    $check = new \User\Auth\CheckAuth();

    echo '<pre>';
    print_r( $check -> check() );
    echo '</pre>';
  }
}