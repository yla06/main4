<?php
trait ProductTrait
{
  private $_name;
  private $_type;
  private $_freezer = false;

  public function __construct( $name, $qv, $type, $freezer = false )
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

  public function setFreezer( $bool )
  {
    $this -> _freezer = (bool)$bool;
  }

  public function getName()
  {
    return $this -> _name;
  }

  public function getType()
  {
    return $this -> _type;
  }

  public function isFreezer()
  {
    return $this -> _freezer;
  }
}
