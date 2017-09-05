<?php
require 'config.php';
require 'header.php';

$module = ( isset( $_GET['module'] ) ) ? $_GET['module'] : 'index';

//1
if ( strpos( $module, '../') !== false )
  echo 'В имени модуля найдены запрещенные символы';
else
{
  if ( file_exists( "modules/{$module}.php" ) )
    require "modules/{$module}.php";

  else
    echo 404;
}

//2
//while ( $module !== $tmodule = str_replace( '../', '', $module ) )
//  $module = $tmodule;
//
//if ( file_exists( "modules/{$module}.php" ) )
//  require "modules/{$module}.php";
//
//else
//  echo 404;

//3
//$a_modules = [
//  'index', 'about', 'contact', 'catalog', 'product'
//];
//
//if ( in_array( $module, $a_modules ) )
//  require "modules/{$module}.php";
//
//else
//  echo 404;

//4
//if ( $module == 'about' )
//  require 'modules/about.php';
//
//else if ( $module == 'contact' )
//  require 'modules/contact.php';
//
//else if ( $module == 'index' )
//  require 'modules/index.php';
//
//else if ( $module == 'catalog' )
//  require 'modules/catalog.php';
//
//else
//  echo 404;

require 'footer.php';