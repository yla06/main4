<?php
$data   = unserialize( file_get_contents( 'blog.dat' ) );

$key    = ( isset( $_GET[ 'key' ] ) and is_string( $_GET['key'] ) ) ? $_GET[ 'key' ] : false;

if ( false === $key or ! isset( $data[$key] ) )
  exit( 'Ключ не найден' );
?>

<h1><?= htmlspecialchars( $data[$key]['title'] ) ?></h1>
<div style="background-color: greenyellow"><?= htmlspecialchars( $data[$key]['text'] ) ?></div>