<?php
$link = @mysql_connect( DB_HOST, DB_USER, DB_PASS );

if ( ! $link )
  exit( 'Ошибка соединения: ' . mysql_error(  ) );

$db_selected = mysql_select_db( DB_BASE, $link );

if ( ! $db_selected )
  exit( 'Не удалось выбрать базу: ' . mysql_error(  ) );

mysql_query( "SET collation_connection = utf8_unicode_ci" );
mysql_query( "SET NAMES utf8" );