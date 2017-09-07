<?php
//Холодильник
require_once 'FridgeInterface.php';
require_once 'FridgeTrait.php';

abstract class FridgeAbstract implements FridgeInterface
{
  use FridgeTrait;
}