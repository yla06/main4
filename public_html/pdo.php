<?php
try
{
  $pdo = new PDO(
    'mysql:host=localhost;dbname=test1',
    'test1',
    '12345q',
    [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8', time_zone = '+00:00'",
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
}
catch ( PDOException $e )
{
  exit( 'Подключение не удалось: ' . $e -> getMessage() );
}

//2
//$result = $pdo -> query( "SELECT * FROM `blog`" );
//
////while ( $row = $result -> fetch(  ) )
////{
////  echo '<pre>';
////  print_r( $row );
////  echo '</pre>';
////}
//
//
//echo '<pre>';
//print_r( $result -> fetchAll() );
//echo '</pre>';
//exit;

$id = ( isset( $_GET[ 'id' ] ) and is_string( $_GET[ 'id' ] ) ) ? $_GET[ 'id' ] : 0;

////4
echo "SELECT * FROM `blog` WHERE `id` = {$id}";
echo '<pre>';
print_r("SELECT * FROM `blog` WHERE `id` = '12 or id = 13'    ");
echo '</pre>';

$stm = $pdo -> prepare( "SELECT * FROM `blog` WHERE `id` = '12 or id = 13'    " );
$stm -> execute( [$id] );
echo '<pre>';
print_r( $stm -> fetchAll(  ) );
echo '</pre>';
exit;

////5
//$stm = $pdo -> prepare( "SELECT * FROM `blog` WHERE `id` = :id OR `id` = :id2 " );
//$stm -> execute( ['id2' => 111, 'id' => 12] );
//
//$all = $stm -> fetch(  );
//echo '<pre>';
//print_r( $all );
//echo '</pre>';

////7
//$stm = $pdo -> prepare( 'SELECT `title`, `text` FROM `blog` WHERE `id` = ?' );
//$stm -> execute( [11] );
//
//echo '<pre>';
//print_r( $stm -> fetchColumn( 0 ) );
//echo '</pre>';


//$limit = 2;
//$start = 1;
//$stm = $pdo -> prepare( "SELECT * FROM `blog` LIMIT :start, :limit" );
//
//$stm -> bindValue( 'start', $start, PDO::PARAM_INT );
//$stm -> bindValue( 'limit', $limit, PDO::PARAM_INT );
//
//$stm -> execute(  );
//echo '<pre>';
//print_r( $stm -> fetchAll() );
//echo '</pre>';

//$pdo -> exec( "UPDATE `blog` SET `title` = 'aaaaaaaaaaa' WHERE `id` = 11 " );


//$stm = $pdo -> prepare( "UPDATE `blog` SET `title` = 'aaaaaaaaaaa' WHERE `id` = ?" );
//$stm -> execute( [11] );
//
//
//$pdo -> beginTransaction();
//$stm = $pdo -> exec( "UPDATE `blog` SET `title` = '" . time(  ) . "' WHERE `id` = 5" );
//
//echo time(  );
//echo '<hr />';
//echo $rand = rand( 0, 1 );
//
//if ( $rand )
//  $pdo -> commit();
//else
//  $pdo -> rollBack( );