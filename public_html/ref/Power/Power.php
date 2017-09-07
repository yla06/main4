<?php
class Power
{
  private static $_power = true;

  public static function on(  )
  {
    self::$_power = true;
  }

  public static function off(  )
  {
    self::$_power = false;
  }

  public static function getPower(  )
  {
    return self::$_power;
  }
}