<?php
//Холодильник
require_once 'GeneralInterface.php';

abstract class GeneralAbstract implements GeneralInterface
{
  private $_products = [];

  public function setProduct( ProductGeneralInterface $product )
  {
    echo 'Переносим продукт "' . $product -> getName() . '"<br />';
    $this -> _products[] = $product;

    if ( $product -> isFreezer() )// Это надо в морозиловку
    {
      if ( $this instanceof FreezerInterface )
      {
        //Перебор контенеров морозиловки со свободным местом
      }
      else
      {
        echo '<b>Этот продукт надо хранить в морозиловке которого у этого холодильника нет</b><br />';
      }
    }
    else// Это надо в холодильник
    {
      if ( $this instanceof FridgeInterface )
      {
        //Перебор полок холодильника со свободным местом
      }
      else
      {
        echo '<b>Этот продукт надо хранить в холодильнике которого у этого морозильника нет</b><br />';
      }
    }
  }

  public function setProducts( array $products )
  {
    echo 'Переносим продукты<br />';

    foreach ( $products as $product )
      $this -> setProduct ( $product );
  }

  public function closeDoor()
  {
    echo 'Дверь открыта<br />';
  }

  public function openDoor()
  {
    echo 'Дверь закрыта<br />';
  }

  public function setbasket( Basket $basket )
  {
    echo 'Работаем с корзиной<br />';
    $this -> setProducts( $basket -> getProducts() );
  }
}