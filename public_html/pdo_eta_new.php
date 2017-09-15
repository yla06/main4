<?php
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

//2
//$sql = "SELECT * FROM `blog`";
//
//try
//{
//  $result = $pdo -> query( $sql );
//
//  if ( $result -> rowCount() )
//  {
//////2.1
////    echo '<pre>';
////    print_r( $result -> fetchAll(  ) );
////    echo '</pre>';
//////2.2
////    while ( $row = $result -> fetch(  ) )
////    {
////      echo '<pre>';
////      print_r( $row );
////      echo '</pre>';
////    }
//  }
//  else
//    echo 'No data';
//}
//catch ( PDOException $e )
//{
//  exit( 'SQL dasdas' );
//}

////2
//$sql = "INSERT INTO `test_blog` (`blog_title`, `blog_text`) VALUES
//( 'test', 'test' ),
//( 'test2', 'test3' ),
//( 'test4', 'test4' ) ";
//
//try
//{
//  if ( $rows = $pdo -> exec( $sql ) )
//    echo $rows . ' Added';
//  else
//    echo 'No affected';
//}
//catch ( PDOException $e )
//{
//  exit( $e -> getMessage() );
//}

////3
//$id = ( isset( $_GET[ 'id' ] ) and is_string( $_GET[ 'id' ] ) ) ? $_GET[ 'id' ] : 0;
//
//$stm = $pdo -> prepare( "UPDATE `blog` SET `title` = 'test' WHERE `id` = ? " );
//$stm -> execute( [$id] );

////4
//$sql = "SELECT * FROM `blog` WHERE `id` = ? ";
////$sql = "SELECT * FROM `blog` WHERE `id` = :id ";// named
//
//$stm = $pdo -> prepare( $sql );
//$stm -> execute( [$id] );
////$stm -> execute( ['id' => $id] );// named
//
//echo '<pre>';
//print_r( $stm -> fetch(  ) );
////print_r( $stm -> fetchAll(  ) );
//echo '</pre>';

////5
//$stm = $pdo -> prepare( "SELECT * FROM `blog` WHERE `id` = :id OR `id` = :id2 " );
//$stm -> execute( ['id2' => 111, 'id' => 12] );
//
//echo '<pre>';
//print_r( $stm -> fetch(  ) );
//echo '</pre>';

////6
//$stm = $pdo -> prepare( 'SELECT `title`, `text` FROM `blog` WHERE `id` = ?' );
//$stm -> execute( [11] );
//
//echo '<pre>';
//print_r( $stm -> fetchColumn( 0 ) );
//echo '</pre>';

////7
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