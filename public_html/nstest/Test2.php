<?php

namespace Test2;

const FOO = 2;

function foo()
{
  echo 2;
}

class Foo
{

  public function __construct()
  {
    echo \FOO;
  }

}
