<?php

spl_autoload_register( 'myautoload2' );
spl_autoload_register( 'myautoload1' );
spl_autoload_register( 'myautoload3' );

//spl_autoload_unregister( 'myautoload1' );

foreach ( spl_autoload_functions() as $function )
{
  spl_autoload_unregister( $function );
}


spl_autoload_register( 'myautoload2' );
spl_autoload_register( 'myautoload1' );
spl_autoload_register( 'myautoload3' );

new class1;
new class2;


new class22;
new class4;

//function __autoload( $classname )
//{
////1
////  if ( $classname == 'class1' )
////    require 'Classes/class1.php';
////
////  else if ( $classname == 'class2' )
////    require 'Classes/class2.php';
////
////  else if ( $classname == 'class4' )
////    require 'Classes/user/class4.php';
//
////2
////  switch ( $classname )
////  {
////    case 'class1': require 'Classes/class1.php'; break;
////    case 'class2': require 'Classes/class2.php'; break;
////    case 'class4': require 'Classes/user/class4.php'; break;
////  }
//
////3
////  if ( file_exists( $path = "Classes/{$classname}.php" ) )
////    require $path;
////  else
////  {
////    if ( file_exists( $path = "Classes/user/{$classname}.php" ) )
////      require $path;
////  }
//}


function myautoload1( $classname )
{
  echo '<b>1</b>';

  if ( $classname == 'class1' )
    require 'Classes/class1.php';

  else if ( $classname == 'class2' )
    require 'Classes/class2.php';

  else if ( $classname == 'class22' )
    require 'Classes/class22.php';
}

function myautoload2( $classname )
{
  echo '<b>2</b>';

  switch ( $classname )
  {
    case 'class1': require 'Classes/class1.php';
      break;
    case 'class2': require 'Classes/class2.php';
      break;
  }
}

function myautoload3( $classname )
{
  echo '<b>3</b>';

  if ( file_exists( $path = "Classes/{$classname}.php" ) )
    require $path;
  else
  {
    if ( file_exists( $path = "Classes/user/{$classname}.php" ) )
      require $path;
  }
}

