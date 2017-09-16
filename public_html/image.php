<?php
$im = imagecreatetruecolor( 400, 300 );

$color = imagecolorallocate( $im, 255, 255, 255 );
$color2 = imagecolorallocate( $im, 190, 12, 104 );

imagefill( $im, 0, 0, $color );

//imageSetPixel( $im, rand(0,400), rand(0,300), $color2 );

imageSetPixel( $im, 110, 80, $color2 );
//imageSetPixel( $im, 111, 80, $color2 );
//imageSetPixel( $im, 112, 80, $color2 );
//imageSetPixel( $im, 113, 80, $color2 );
//imageSetPixel( $im, 114, 80, $color2 );
//imageSetPixel( $im, 115, 80, $color2 );
//imageSetPixel( $im, 110, 81, $color2 );
//imageSetPixel( $im, 111, 81, $color2 );
//imageSetPixel( $im, 112, 81, $color2 );
//imageSetPixel( $im, 113, 81, $color2 );
//imageSetPixel( $im, 114, 81, $color2 );
//imageSetPixel( $im, 115, 81, $color2 );

imageLine( $im, 10, 220, 180, 190, imageColorAllocate( $im, 255, 0, 0  ) );

imageSetThickness( $im, 15 );

imageLine( $im, 9, 9, 9, 290, imageColorAllocate( $im, 255, 0, 0  ) );


imageSetThickness( $im, 4 );

imageLine( $im, 310, 10, 280, 290, imageColorAllocate( $im, 255, 0, 0  ) );

imageSetThickness( $im, 5 );

imageDashedLine( $im, 110, 20, 80, 90, imageColorAllocate( $im, 255, 100, 50  ) );
imagerectangle( $im, 15, 50, 55, 200, imageColorAllocate( $im, 255, 0, 0  ) );

imageFilledRectangle( $im, 25, 60, 75, 220, $color2 );

imageArc($im, 150, 100, 100, 100, 90, 90, $color2 );
//imagefilledellipse($im, 200, 150, 200, 200, $color2);
imageellipse($im, 200, 150, 200, 200, $color2);
imagePolygon($im, [10, 20, 120, 250, 190, 290, 100, 290, 100, 20], 4, imageColorAllocate( $im, 0, 255, 50  ));

imageString( $im, 5, 125, 10, rand(1, 999), imageColorAllocate( $im, 0, 255, 50  ));

header( 'Content-Type: image/jpeg' );

imagejpeg( $im );
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
