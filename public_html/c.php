<?php
$im = imagecreatetruecolor( 35, 20 );

imagefill( $im, 0, 0,  imagecolorallocate( $im, 255, 255, 255 ) );
imageString( $im, 5, 5, 2, rand( 100, 999 ), imageColorAllocate( $im, rand( 0, 100 ), rand( 0, 100 ), rand( 0, 100 ) ) );
header( 'Content-Type: image/jpeg' );

imagejpeg( $im, null, 100 );  