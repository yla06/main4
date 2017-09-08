<?php
require_once 'FreezerAbstract.php';
require_once 'FridgeAbstract.php';
require_once 'FFAbstract.php';

class Ariston extends FreezerAbstract
{
  protected $_container = [50, 50, 60];
}

class Atlant extends FridgeAbstract
{
  protected $_egg   = 6;
  protected $_shelf = [ 50, 100 ];
}

class Indesit extends FFAbstract
{
  protected $_egg   = 10;
  protected $_shelf = [ 10, 20, 25 ];
}