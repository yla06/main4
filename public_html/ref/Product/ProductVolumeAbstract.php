<?php
require_once 'ProductVolumeInterface.php';
require_once 'ProductGeneralInterface.php';
require_once 'ProductTrait.php';

abstract class ProductVolumeAbstract implements ProductGeneralInterface, ProductVolumeInterface
{
  use ProductTrait;

  private $_volume;

  public function setVolume( $volume )
  {
    $this -> _volume = $volume;
  }
}