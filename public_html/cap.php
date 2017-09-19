<?php
session_start();
$_SESSION['captcha'] = '';

$im = imagecreatetruecolor( 100, 50 );
imagefill( $im, 0, 0,  imagecolorallocate( $im, rand(200,255), rand(200,255), rand(200,255) ) );

for ( $i = 0, $j = 15; $i < 5; $i++, $j +=15 )
{
  $_SESSION['captcha'] .= $rand = rand( 1, 9 );//77777
  imageString( $im, 5, ( $j + rand( -5, 5 ) ), ( 18 + rand( -8, 8 ) ), $rand, imageColorAllocate( $im, rand( 0, 100 ), rand( 0, 100 ), rand( 0, 100 ) ) );
}

for( $i = 0; $i < 200; $i++ )
{
  imageSetPixel( $im, rand( 0, 100 ), rand( 0, 50 ), imagecolorallocate( $im, rand( 0, 255 ), rand( 0, 255 ), rand( 0, 255 ) ) );
}

for( $i = 0; $i < 10; $i++ )
{
  if ( rand( 0, 1 ) )
    imageLine( $im, rand( 0, 100 ), rand( 0, 50 ), rand( 0, 100 ), rand( 0, 50 ), imagecolorallocate( $im, rand( 100, 255 ), rand( 100, 255 ), rand( 100, 255 ) ) );
  else
    imageDashedLine( $im, $x = rand( 0, 100 ), $y = rand( 0, 50 ), $x + rand( 0, 10 ), $x + rand( 0, 10 ), imagecolorallocate( $im, rand( 100, 255 ), rand( 100, 255 ), rand( 100, 255 ) ) );
}

$ap = [];

for( $i = 0; $i < 10; $i++ )
{
  $ap[] = rand( 0, 100 );
  $ap[] = rand( 0, 50 );
}

imagePolygon($im, $ap, rand( 3, 10 ), imagecolorallocate( $im, rand( 150, 255 ), rand( 150, 255 ), rand( 150, 255 ) ));

header( 'Content-Type: image/jpeg' );

imagejpeg( $im, null, 100 );
//imagepng( $im, null, 9, PNG_NO_FILTER );
//imagepng( $im, $_SERVER['DOCUMENT_ROOT'] . '/upload/55555555.jpg', 100 );
//imagegif( $im, null, 100 );

exit;

//
//$text = rand(1, 999);
//$font = $_SERVER['DOCUMENT_ROOT'] . '/Font.ttf';
//
//$r = rand(1,20);
//$r2 = rand(10,20);
//imageTtfText($im, $r2, $r, 115, 125, imageColorAllocate( $im, 255, 0, 0 ), $font, $text);
//imageTtfText($im, $r2, $r, 110, 120, imageColorAllocate( $im, 255, 255, 255 ), $font, $text);
//
//
//$original = imagecreatefromjpeg( '3.jpg' );
//$copy     = imagecreatetruecolor( 500, 375 );
//
//imagecopyresampled( $copy, $original, 0, 0, 0, 0, 500, 375, imagesx( $original ), imagesy( $original ) );
//
//imagefilter( $copy, IMG_FILTER_PIXELATE, 20, IMG_FILTER_PIXELATE );
//
//header( 'Content-Type: image/jpeg' );
//imagejpeg( $copy );


//$original = imagecreatefromjpeg( '3.jpg' );
//
//$orig_x = imagesx( $original );
//$orig_y = imagesy( $original );
//
////$width = 200;
////
////$new_x = $width;
////$new_y = round( $orig_y * $width / $orig_x );
//
//$wh = 300;
//
//$ratio = $orig_x / $orig_y;
//
//if ( $orig_x > $orig_y )
//{
//  $new_x = $wh;
//  $new_y = $wh / $ratio;
//}
//else
//{
//  $new_x = $wh * $ratio;
//  $new_y = $wh;
//}
//
//$copy = imagecreatetruecolor( $new_x, $new_y );
//imagecopyresampled( $copy, $original, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y );
//
//
//
//
//imageString( $copy, 5, 25, 50, rand(1, 999), $color);
//
//$text = rand(1, 999);
//$font = $_SERVER['DOCUMENT_ROOT'] . '/Font.ttf';
//
//$r = rand(1,20);
//$r2 = rand(10,20);
//imageTtfText($copy, $r2, $r, 115, 125, imageColorAllocate( $copy, 255, 0, 0 ), $font, $text);
//imageTtfText($copy, $r2, $r, 110, 120, imageColorAllocate( $copy, 255, 255, 255 ), $font, $text);
//
//
//
//header( 'Content-Type: image/jpeg' );
//imagejpeg( $copy );
