<?php
set_time_limit( 120 );
try
{
  $pdo = new PDO(
    'mysql:host=localhost;dbname=test1',
    'test1',
    '12345q',
    [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8', time_zone = '+00:00'",
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
}
catch ( PDOException $e )
{
  exit( 'Подключение не удалось: ' . $e -> getMessage() );
}


//1 Запустить когда надо разметить исходное избражение
$image  = new Imagick( '1.jpg' );
$width  = $image -> getimagewidth();
$height = $image -> getimageheight();

//$sql = "INSERT INTO `graph` ( `graph_x`, `graph_y`, `graph_r`, `graph_g`, `graph_b` ) VALUES ";
//
//for ( $x = $y = 0; $y < $height; $x ++ )
//{
//  $arr = $image -> getImagePixelColor( $x, $y ) -> getColor();
//  list( $r, $g, $b, ) = array_values( $arr );
//
//  $sql .= "( {$x}, {$y}, {$r}, {$g}, {$b} ),";
//
//  if ( $x == $width )
//  {
//    $y ++;
//    $x = -1;
//  }
//}
//
//$pdo -> exec( trim( $sql, ',' ) );
//exit(  );

// Создает изображение для нанесения фотографий в 20 раз больше исходного
//$image = new Imagick();
//$dtp  = 20;
//$image -> newImage( $width * $dtp, $height * $dtp, new ImagickPixel( 'white' ) );
//$image -> setImageFormat( 'png' );
//$image -> writeImage( 'new1.png' );
//exit;

//foreach (glob( 'files/nocheck/*.{png,jpg,jpeg}', GLOB_BRACE ) as $file)
//{
//  rename( $file, "files/nocheck/".rand(1, 999999999999999).".jpg" );
//}
//exit( 'Stoped: <b>' . mf_get_spath() . '</b>' );


$images = glob( 'files/nocheck/*.{png,jpg,jpeg}', GLOB_BRACE );

if ( $images )
{
  $pdo -> query( "SET sql_mode = 'NO_UNSIGNED_SUBTRACTION'" );

  foreach ( $images as $curr_image )
  {
//  echo $curr_image = $images[0];

    $image = new Imagick( $curr_image );
    $image -> thumbnailImage( 1, 1, true, true );
    //$image -> resizeImage( 1, 1, Imagick::FILTER_LANCZOS, 0 );
    //header( 'Content-Type: image/jpeg' );
    //exit( $image );

    $arr = $image -> getImagePixelColor( 1, 1 ) -> getColor();

    list( $r, $g, $b, ) = array_values( $arr );
    var_dump( $r, $g, $b );

    $sql = "CREATE TEMPORARY TABLE `tmp_table`
            SELECT
              `graph_id`, `graph_x`, `graph_y`,
              30*SQRT(POW(`graph_r`-{$r}, 2)+59*POW(`graph_g`-{$g}, 2)+11*POW(`graph_b`-{$b}, 2)) AS 'diff'
            FROM `graph`
            WHERE
              `graph_status` = '0'
              AND `graph_r` >= '" . ($r - 50) . "' AND `graph_r` <= '" . ($r + 50) . "'
              AND `graph_g` >= '" . ($g - 50) . "' AND `graph_g` <= '" . ($g + 50) . "'
              AND `graph_b` >= '" . ($b - 50) . "' AND `graph_b` <= '" . ($b + 50) . "'";

    $pdo -> exec( $sql );

    // Выборка наименьшего отличия цветов.

    $sql = "SELECT * FROM `tmp_table` WHERE `diff` >= '0' ORDER BY `diff` ASC LIMIT 1";

    $res   = $pdo -> query( $sql );
    $graph = $res -> fetch();
    $pdo -> exec( "DROP TEMPORARY TABLE IF EXISTS `tmp_table`" );

    if ( $graph )
    {
      $sql = "UPDATE `graph` SET `graph_status` = '1' WHERE `graph_id` = '{$graph[ 'graph_id' ]}'";
      $pdo -> exec( $sql );
      // Обновлние хоста
      $orig = imagecreatefrompng( 'new1.png' );
      $copy = imagecreatefromjpeg( $curr_image );

      $dtp  = 20;
      $resc = imagecreatetruecolor( $dtp, $dtp );
      imagecopyresampled( $resc, $copy, 0, 0, 0, 0, $dtp, $dtp, imagesx( $copy ), imagesy( $copy ) );

      $rw     = $graph[ 'graph_x' ] * $dtp;
      $rh     = $graph[ 'graph_y' ] * $dtp;
      $coordx = imagecopymerge( $orig, $resc, $rw, $rh, 0, 0, $dtp, $dtp, 100 );

      imagepng( $orig, 'new1.png' );
      imagedestroy( $copy );
      imagedestroy( $orig );
      echo 'Фото подходит<hr />';
//      rename( $curr_image, "files/ok/{$graph[ 'graph_id' ]}.jpg" );
    }
    else
    {
      echo "Фото '{$images[ 0 ]}' не подходит<hr />";
      rename( $curr_image, str_replace( '/nocheck/', '/bad/', $curr_image ) );
    }
  }
}

echo '<img src="new1.png">';