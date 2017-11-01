<?php

namespace Test2;

const FOO = 2;

function foo()
{
  echo \FOO;
}

class Foo
{

  public function __construct()
  {
    echo 2;
  }

}
