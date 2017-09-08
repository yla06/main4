<?php
require_once 'core/config.php';

session_start();

require_once 'core/function.php';
require_once 'core/validate.php';

$link = @mysql_connect( MC_DB_HOST, MC_DB_USER, MC_DB_PASS );

if ( ! $link )
  die( 'Ошибка соединения: ' . mysql_error(  ) );

$db_selected = mysql_select_db( MC_DB_BASE, $link );

if ( ! $db_selected )
  die( 'Не удалось выбрать базу: ' . mysql_error(  ) );

mysql_query( "SET collation_connection = utf8_general_ci" );
mysql_query( "SET NAMES utf8" );