<?php
require_once 'bootstrap.php';

$data   = unserialize( file_get_contents( 'blog.dat' ) );

$key    = ( isset( $_GET[ 'key' ] ) and is_string( $_GET['key'] ) ) ? $_GET[ 'key' ] : false;

if ( false === $key or ! isset( $data[$key] ) )
  exit( 'Ключ не найден' );

$token  = ( isset( $_GET[ 'token' ] ) and is_string( $_GET['token'] ) ) ? $_GET[ 'token' ] : false;

if ( $token != session_id(  ) )
  exit( 'Токен не найден' );

unset( $data[$key] );

file_put_contents( 'blog.dat', serialize( $data ) );
exit( header( 'Location: index.php' ) );
