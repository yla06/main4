<?php
class Basket
{
  protected $_products = [];

  public function setProducts( array $products )
  {
    foreach ( $products as $product )
      $this -> setProduct ( $product );
  }

  public function setProduct( ProductGeneralInterface $product )
  {
    $this -> _products[] = $product;
  }

  public function getProducts(  )
  {
    return $this -> _products;
  }
}