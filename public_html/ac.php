<?php
$original = imagecreatefromstring( file_get_contents( 'http://main4.phpstep.com.ua/c.php' ) );

$text = 999;
//echo '<pre>';
//print_r( imagecolorsforindex( $original, imagecolorat($original, 8, 10 ) ) );
//echo '</pre>';

/**
 * Эту часть кода не изменять. Весь код писать выше.
 */
$image = imagecreatetruecolor( 35, 40 );
imagecopyresampled( $image, $original, 0, 0, 0, 0, 35, 20, imagesx( $original ), imagesy( $original ) );

imageString( $image, 5, 5, 22, $text, imageColorAllocate( $image, 255, 0, 0 ) );
header( 'Content-Type: image/jpeg' );
imagejpeg( $image, null, 100 );