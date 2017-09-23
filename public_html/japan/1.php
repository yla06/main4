<?php
set_time_limit(60);
$cof_sum = 620;
$original = imagecreatefromjpeg( 'a3.jpg' );
$orig_x = imagesx( $original );
$orig_y = imagesy( $original );

$wh = 200;

$ratio = $orig_x / $orig_y;

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

$image = imagecreatetruecolor( $new_x, $new_y );
imagecopyresampled( $image, $original, 0, 0, 0, 0, $new_x, $new_y, $orig_x, $orig_y );




$realw = imagesx( $image );
$realh = imagesy( $image );
$size = 20;

$big = imagecreatetruecolor( $realw * $size, $realh * $size );

define( 'COLOR_BLACK', imagecolorallocate( $big, 0, 0, 0 ) );
define( 'COLOR_WHITE', imagecolorallocate( $big, 255, 255, 255 ) );

imagefill( $big, 0, 0, COLOR_WHITE );

$bigw = imagesx( $big );
$bigh = imagesy( $big );

$vertical = $horizontal = [];

for( $y = 0, $sy = 0; $y < $realh; $y++ )
{
  if ( $y % 5 === 0 or $y == 0 )
  {
    imageSetThickness( $big, 2 );
    imageLine( $big, 0, $y * $size, $bigw, $y * $size, COLOR_BLACK );
    imageSetThickness( $big, 1 );
    $sy = 1;
  }
  else
    imageLine( $big, 0, $y * $size, $bigw, $y * $size, COLOR_BLACK );

  for( $x = 0, $sx = 0; $x < $realw; $x++ )
  {
    if ( $x % 5 === 0 or $x == 0)
    {
      imageSetThickness( $big, 2 );
      imageLine( $big, $x * $size, 0, $x * $size, $bigh, COLOR_BLACK );
      imageSetThickness( $big, 1 );
      $sx = 1;
    }
    else
    {
      imageLine( $big, $x * $size, 0, $x * $size, $bigh, COLOR_BLACK );
    }

    $sum = array_sum( imagecolorsforindex( $image, imagecolorat( $image, $x, $y ) ) );

    if ( $sum < $cof_sum )
    {
      $vertical[$x][]   = $y;
      $horizontal[$y][] = $x;

      imageFilledRectangle(
        $big,
        $x * $size + 1 + $sx, //xs
        $y * $size + 1 + $sy, //ys
        $x * $size + $size - 1 - $sx - ( ( ($x+1) % 5 == 0 ) ? 1 : 0 ), //xf
        $y * $size + $size - 1 - $sy - ( ( ($y+1) % 5 == 0 ) ? 1 : 0 ), //yf
        COLOR_BLACK
      );
    }
  }
}

list( $vertical_group, $maxcountx ) = prepare_group( $vertical );
list( $horizontal_group, $maxcounty ) = prepare_group( $horizontal );

$hor  = imagecreatetruecolor( $maxcounty * 21, $bigh );
$horw = imagesx( $hor );

imagefill( $hor, 0, 0, COLOR_WHITE );

for( $y = 0; $y <= $bigh; $y++ )
{
  $group = isset( $horizontal_group[$y] ) ? $horizontal_group[$y] : [];

  if ( $y % 5 === 0 or $y == 0 )
  {
    imageSetThickness( $hor, 2 );
    imageLine( $hor, 0, $y * $size, $horw, $y * $size, COLOR_BLACK );
    imageSetThickness( $hor, 1 );
    $sx = 1;
  }
  else
  {
    imageLine( $hor, 0, $y * $size, $horw, $y * $size, COLOR_BLACK );
  }

  foreach ( array_reverse( $group ) as $i => $number )
  {
    $right = ( $number > 9 ) ? 5 : 0;
    imageString( $hor, 4, $horw - 15 - ($i * 20) - $right, $y * 20 + 3, $number, COLOR_BLACK );
  }
}

$vert  = imagecreatetruecolor( $bigw, $maxcountx * 15 );
$verth = imagesy( $vert );

imagefill( $vert, 0, 0, COLOR_WHITE );

for( $x = 0; $x <= $bigw; $x++ )
{
  $group = isset( $vertical_group[$x] ) ? $vertical_group[$x] : [];

  if ( $x % 5 === 0 or $x == 0 )
  {
    imageSetThickness( $vert, 2 );
    imageLine( $vert, $x * $size, 0, $x * $size, $verth, COLOR_BLACK );
    imageSetThickness( $vert, 1 );
    $sx = 1;
  }
  else
  {
    imageLine( $vert, $x * $size, 0, $x * $size, $verth, COLOR_BLACK );
  }

  foreach ( array_reverse( $group ) as $i => $number )
  {
    $left = ( $number > 9 ) ? 2 : 5;
    imageString( $vert, 4, $x * 20 + $left, $verth - 15 - ($i * 15), $number, COLOR_BLACK );
  }
}



$full = imagecreatetruecolor( $bigw + $horw, $bigh + $verth );
$fullw = imagesx( $full );
$fullh = imagesy( $full );

imagecopyresampled( $full, $hor, 0, imagesy( $vert ), 0, 0, imagesx( $hor ), imagesy( $hor ), imagesx( $hor ), imagesy( $hor ) );
imagecopyresampled( $full, $vert, imagesx( $hor ), 0, 0, 0, imagesx( $vert ), imagesy( $vert ), imagesx( $vert ), imagesy( $vert ) );
imagecopyresampled( $full, $big, imagesx( $hor ), imagesy( $vert ), 0, 0, imagesx( $big ), imagesy( $big ), imagesx( $big ), imagesy( $big ) );



header( 'Content-Type: image/png' );
imagepng( $full );


function prepare_group( $vh )
{
  ksort( $vh );

  $vh_group = [];
  $maxcount = 0;

  foreach ( $vh as $id => $onerow )
  {
    $count = 0;
    $group = false;

    foreach ( $onerow as $line )
    {
      if ( false != $group )
      {
        if ( ( $group + 1 ) != $line )
        {
          if ( $count )
            $vh_group[ $id ][] = $count;

          $count = 0;
        }
      }

      $group = $line;
      $count ++;
    }

    if ( $count )
      $vh_group[ $id ][] = $count;

    $maxcount = ( $maxcount < $c = count( $vh_group[ $id ] ) ) ? $c : $maxcount;
  }

  return [$vh_group, $maxcount];
}
