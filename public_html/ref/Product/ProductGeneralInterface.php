<?php
interface ProductGeneralInterface
{
  const PRODUCT_TYPE_QUANTITY = 1;
  const PRODUCT_TYPE_VOLUME   = 2;

  public function __construct( $name, $qv, $type );
}