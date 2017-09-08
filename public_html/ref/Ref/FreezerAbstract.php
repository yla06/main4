<?php
//Морозильник
require_once 'GeneralAbstract.php';
require_once 'FreezerInterface.php';
require_once 'FreezerTrait.php';

abstract class FreezerAbstract extends GeneralAbstract implements FreezerInterface
{
  use FreezerTrait;

  // все реализуется в трейте!!!!!!!!!!!
}