<?php
trait ProductTrait
{
  private $_name;
  private $_type;

  public function __construct( $name, $qv, $type )
  {
    $this -> _name  = $name;
    $this -> _type  = $type;

    switch ( $type )
    {
      case ProductGeneralInterface::PRODUCT_TYPE_QUANTITY:
        $this -> _quantity = $qv;
        break;

      case ProductGeneralInterface::PRODUCT_TYPE_VOLUME:
        $this -> _volume = $qv;
        break;

      default:
        exit( 'Error! Undefined product type!' );
        break;
    }
  }
}
