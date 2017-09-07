<?php
require_once 'ProductQuantityInterface.php';
require_once 'ProductGeneralInterface.php';
require_once 'ProductTrait.php';

abstract class ProductQuantityAbstract implements ProductGeneralInterface, ProductQuantityInterface
{
  use ProductTrait;

  private $_quantity;

  public function setQuantity( $quantity )
  {
    $this -> _quantity = $quantity;
  }
}