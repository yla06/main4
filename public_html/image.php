<?php
$im = imagecreatetruecolor( 400,300 );

$color  = imagecolorallocate( $im, 255, 255, 255 );
$color2 = imagecolorallocate( $im, 190, 12, 104 );
////1 
//imagefill( $im, 0, 0, $color );
//imageSetPixel( $im, rand( 0, 400 ), rand( 0, 300 ), $color2 );
//imageSetPixel( $im, 110, 80, $color2 );
//imageLine( $im, 10, 220, 180, 190, imageColorAllocate( $im, 255, 0, 0  ) );
//imageSetThickness( $im, 15 );
//imageLine( $im, 9, 9, 9, 290, imageColorAllocate( $im, 255, 0, 0  ) );
//imageSetThickness( $im, 4 );
//imageLine( $im, 310, 10, 280, 290, imageColorAllocate( $im, 255, 0, 0  ) );
//imageSetThickness( $im, 5 );
//imageDashedLine( $im, 110, 20, 80, 90, imageColorAllocate( $im, 255, 100, 50  ) );
//imagerectangle( $im, 15, 50, 55, 200, imageColorAllocate( $im, 255, 0, 0  ) );
//imageFilledRectangle( $im, 25, 60, 75, 220, $color2 );
//imageArc($im, 150, 100, 100, 100, 90, 90, $color2 );
//imagefilledellipse($im, 200, 150, 200, 200, $color2);
//imageellipse($im, 200, 150, 200, 200, $color2);
//imagePolygon($im, [10, 20, 120, 250, 190, 290, 100, 290, 100, 20], 4, imageColorAllocate( $im, 0, 255, 50  ));
//imageString( $im, 5, 125, 10, rand(1, 999), imageColorAllocate( $im, 0, 255, 50  ));

////2
//$font = $_SERVER[ 'DOCUMENT_ROOT' ] . '/font2.ttf';
//$text = 'ПРивет ' . rand( 1, 999 );
//
//$x = imagesx( $im ) - 160;
//$y = imagesy( $im ) - 10;
//
//imageTtfText( $im, 30, 0, $x, $y, imageColorAllocate( $im, 255, 0, 0 ), $font, $text );
//imageTtfText( $im, 30, 0, $x-2, $y-2, imageColorAllocate( $im, 100, 0, 0 ), $font, $text );
//
//$text = '12345678901234567890';
//$a = imagettfbbox( 20, 0, $font, $text );
//
//$real_x = imagesx( $im );
//$real_y = imagesy( $im );
//
//imageTtfText($im, 20, 0, ( $real_x / 2 ) - ( $a[2] / 2 ), ( $real_y / 2 ) - ( $a[5] / 2 ), imageColorAllocate( $im, 255, 0, 0 ), $font, $text);
//header( 'Content-Type: image/jpeg' );
//imagejpeg( $im );
////imagepng( $im, null, 9, PNG_NO_FILTER );
////imagepng( $im, $_SERVER['DOCUMENT_ROOT'] . '/upload/55555555.jpg', 100 );
////imagegif( $im, null, 100 );
//exit;


/**
 * Измененние размера картинки без сохранения пропорций оригинальной картинки.
 */
//$original = imagecreatefromjpeg( 'pic2.jpg' );
//$copy     = imagecreatetruecolor( 500, 275 );

//
////imagecopyresized($copy, $original, 0, 0, 0, 0, 500, 275, imagesx( $original ), imagesy( $original ) );
//imagecopyresampled( $copy, $original, 0, 0, 0, 0, 500, 275, imagesx( $original ), imagesy( $original ) );
//
/**
 * Нанесение вотермарка в виде картинки
 */
//imagecopyresampled( $copy, $wm , 440, 200, 0, 0, 50, 50, imagesx( $wm ), imagesy( $wm ) );
//
/**
 * Использование простыхфильтров
 */
////imagefilter( $copy, IMG_FILTER_GRAYSCALE );
////imagefilter( $copy, IMG_FILTER_PIXELATE, 5, IMG_FILTER_PIXELATE );
//
////imageString( $copy, 5, 125, 10, rand(1, 999), imageColorAllocate( $copy, 0, 255, 50  ));
////imageTtfText( $copy, 50, 0, 352, 251, imageColorAllocate( $copy, 0, 0, 0 ), $_SERVER['DOCUMENT_ROOT'] . '/font2.ttf', 'example' );
////imageTtfText( $copy, 50, 0, 350, 250, imageColorAllocate( $copy, 255, 0, 0 ), $_SERVER['DOCUMENT_ROOT'] . '/font2.ttf', 'example' );
//
//
//header( 'Content-Type: image/jpeg' );
//imagejpeg( $copy );

/**
 * Изменение размера картинки
 */
$original = imagecreatefrompng( 'a1.png' );

$orig_x = imagesx( $original );
$orig_y = imagesy( $original );

/**
 * Фиксированная ширина с сохранением пропорций
 */
//$width = 400;
//
//$new_x = $width;
//$new_y = round( $orig_y * $width / $orig_x );

/**
 * Фиксированная высота с сохранением пропорций
 */
//$height = 100;
//
//$new_x = round( $orig_x * $height / $orig_y );
//$new_y = $height;

/**
 * Фиксированная ширина и высота. Вписывание в размеры с сохранением пропорций
 */
$wh = 300;

$ratio = $orig_x / $orig_y; // 800*600 = 1.3

if ( $orig_x > $orig_y )
{
  $new_x = $wh;
  $new_y = $wh / $ratio;
}
else
{
  $new_x = $wh * $ratio;
  $new_y = $wh;
}

$copy = imagecreatetruecolor( $new_x, $new_y );
imagecopyresampled( $copy, $original, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y );

header( 'Content-Type: image/jpeg' );
imagejpeg( $copy );

