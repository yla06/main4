<?php
$image = imagecreatefrompng( 'test.png' );

$x = imagesx( $image );
$y = imagesy( $image );

for( $h = 0; $h < $y; $h++ )
{
  for( $w = 0; $w < $x; $w++ )
  {
    echo "X:{$w}, Y:{$h}<br />";
    echo '<pre>';
    print_r(imagecolorsforindex( $image, imagecolorat( $image, $w, $h ) ) );
    echo '</pre>';
  }
}