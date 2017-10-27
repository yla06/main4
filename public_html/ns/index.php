<?php
const FOO = 1;

function foo()
{
  echo \Test3\FOO;
}

class Foo
{
  public function __construct()
  {
    echo 1;
  }
}

$root = $_SERVER['DOCUMENT_ROOT'];///var/www/phpstep/data/www/main4.phpstep.com.ua/public_html

include 'Test2.php';
include $root . '/ns/Test3.php';

//echo FOO;
//foo();
//new Foo;
//
//echo Test1\FOO;
//Test1\foo();
//new Test1\Foo();
//new Test1\Bar();
//
//echo Test2\FOO;
//Test2\foo();
//new Test2\Foo();

foo();
Test2\foo();