<?php
function my_autoloader( $class )
{
  $class = $_SERVER['DOCUMENT_ROOT'] . '/ns/' . str_replace( '\\', '/', $class ) . '.php';

  if ( file_exists( $class ) )
    require $class;
}

spl_autoload_register( 'my_autoloader' );

$general = new \User\General;
$general -> blogAdd();
