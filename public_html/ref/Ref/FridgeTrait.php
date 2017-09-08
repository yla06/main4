<?php
//Холодильник
trait FridgeTrait
{
  protected $_egg   = 0;
  protected $_shelf = [];

  public function lightOff()
  {
    echo 'Свет в холодильнике выключен';
  }

  public function lightOn()
  {
    if ( Power::getPower() )
      echo 'Свет в холодильнике включен<br />';

    else
      echo 'Свет в холодильнике НЕ включен! Нет электричества!<br />';
  }
}