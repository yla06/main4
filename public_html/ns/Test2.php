<?php

namespace Test2;

const FOO = 2;

function foo()
{
  echo \Test3\FOO;
}

class Foo
{

  public function __construct()
  {
    echo 2;
  }

}
