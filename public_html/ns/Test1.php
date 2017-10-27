<?php
namespace Test1
{
  const FOO = 2;

  function foo()
  {
    echo 2;
  }

  class Foo
  {
    public function __construct()
    {
      echo 2;
    }
  }
}

namespace Test2
{
  const FOO = 3;

  function foo()
  {
    echo 3;
  }

  class Foo
  {
    public function __construct()
    {
      echo 3;
    }
  }
}

