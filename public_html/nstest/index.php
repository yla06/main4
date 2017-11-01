<?php
const FOO = 1;

function foo()
{
  echo Test3\FOO;
}

class Foo
{
  public function __construct()
  {
    echo 1;
  }
}

include 'Test2.php';
include 'Test3.php';

echo FOO;
foo();
new Foo;

echo Test2\FOO;
Test2\foo();
new Test2\Foo();

echo Test3\FOO;
Test3\foo();
new Test3\Foo();
