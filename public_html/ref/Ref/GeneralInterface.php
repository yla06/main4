<?php
interface GeneralInterface
{
  public function closeDoor();
  public function openDoor();
  public function setProduct( ProductGeneralInterface $product );
  public function setProducts( array $products );
  public function setbasket( Basket $basket );
}