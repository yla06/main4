<?php
//Морозильник
trait FreezerTrait
{
  protected $_container = [];

  public function closeContainer()
  {
    echo 'Закрываем контейнер морозилки<br />';
  }

  public function openContainer()
  {
    echo 'Открываем контейнер морозилки<br />';
  }
}