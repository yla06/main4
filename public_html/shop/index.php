<?php
require_once 'core/bootstrap.php';

$module = ( isset( $_GET['module'] ) ) ? $_GET['module'] : 'index';

ob_start();

if ( strpos( $module, '../') !== false )
  echo 'В имени модуля найдены запрещенные символы';
else
{
  if ( file_exists( MC_CORE . "/modules/index/{$module}.php" ) )
    require MC_CORE . "/modules/index/{$module}.php";

  else
    echo 404;
}

$content = ob_get_clean();

load_template( 'header' );
echo $content;
load_template( 'footer' );