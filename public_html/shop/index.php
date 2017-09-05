<?php
require_once 'core/bootstrap.php';

$module = ( isset( $_GET['module'] ) ) ? $_GET['module'] : 'index';

load_template( 'header' );

if ( strpos( $module, '../') !== false )
  echo 'В имени модуля найдены запрещенные символы';
else
{
  if ( file_exists( MC_CORE . "/modules/index/{$module}.php" ) )
    require MC_CORE . "/modules/index/{$module}.php";

  else
    echo 404;
}

load_template( 'footer' );