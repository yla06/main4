<?php
require_once 'ProductQuantity.php';
require_once 'ProductVolume.php';

class Beer extends ProductQuantity
{
  public function __construct( $name, $qv )
  {
    parent::__construct( $name, $qv, ProductGeneralInterface::PRODUCT_TYPE_QUANTITY );
  }
}

class Milk extends ProductVolume
{
  public function __construct( $name, $qv )
  {
    parent::__construct( $name, $qv, ProductGeneralInterface::PRODUCT_TYPE_VOLUME );
  }
}



