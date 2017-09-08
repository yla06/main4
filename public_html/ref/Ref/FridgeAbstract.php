<?php
//Холодильник
require_once 'Power/Power.php';
require_once 'GeneralAbstract.php';
require_once 'FridgeInterface.php';
require_once 'FridgeTrait.php';

abstract class FridgeAbstract extends GeneralAbstract  implements FridgeInterface
{
  use FridgeTrait;
  // все реализуется в трейте!!!!!!!!!!!
}