<?php
$api_key = ( isset( $_GET['apikey'] ) and is_string( $_GET['apikey'] ) ) ? $_GET['apikey'] : '';
$count   = ( isset( $_GET['count'] )  and is_string( $_GET['count'] ) )  ? $_GET['count']  : '';
$prefix  = ( isset( $_GET['prefix'] )  and is_string( $_GET['prefix'] ) )  ? $_GET['prefix']  : '';

//PR_1234, PR_4234

if ( ! $api_key )
  return_error( 'Ключ не передан' );

//sql
/**
 * $sql = "SELECT * FROM `api_key` WHERE `key` = :api";
 */
if ( false )
  return_error( 'Ключ не найден' );

if ( ! ctype_digit( $count ) or $count < 1 and $count > 20 )
  return_error( 'Количество должно быть в диапазоне 1 - 20' );

if ( ! preg_match( '#^[A-Z0-9]{2,3}$#', $prefix ) )
  return_error( 'Префикс не подходит он должен быть .....' );

$a_code = [];

for( $i = 0; $i < $count; $i++ )
{
  $a_code[] = $prefix . '-' . rand( 1111, 9999 );
}

return_success( $a_code );

function return_error( $text )
{
  exit( json_encode( ['status' => 0, 'error' => $text] ) );
}

function return_success( $data )
{
  exit( json_encode( ['status' => 1, 'data' => $data] ) );
}