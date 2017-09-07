<?php
//Морозильник
require_once 'FreezerInterface.php';
require_once 'FreezerTrait.php';

abstract class FreezerAbstract implements FreezerInterface
{
  use FreezerTrait;

}