<?php
//Холодильник
require_once 'FridgeInterface.php';
require_once 'FreezerInterface.php';
require_once 'GeneralInterface.php';
require_once 'FridgeTrait.php';
require_once 'FreezerTrait.php';

abstract class FFAbstract extends GeneralAbstract implements FridgeInterface
{
  use FridgeTrait;
  use FreezerTrait;
}