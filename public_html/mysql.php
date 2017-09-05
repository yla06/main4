<?php
$link = @mysql_connect( 'localhost', 'test1', '12345q' );

if ( ! $link )
  die( 'Ошибка соединения: ' . mysql_error(  ) );

$db_selected = mysql_select_db( 'test1', $link );

if ( ! $db_selected )
  die( 'Не удалось выбрать базу: ' . mysql_error(  ) );

mysql_query( "SET collation_connection = utf8_general_ci" );
mysql_query( "SET NAMES utf8" );

////1
//$sql = "SELECT * FROM `test_blog` ";
//
//if ( $result = mysql_query( $sql ) )
//{
//  if ( mysql_num_rows( $result ) )
//  {
//    while ( $row = mysql_fetch_assoc( $result ) )
//    {
//      echo '<pre>';
//      print_r($row);
//      echo '</pre>';
//    }
//  }
//  else
//    echo 'No data';
//}
//else
//  echo mysql_error(  );


//$sql = "INSERT INTO `test_blog` (`blog_title`, `blog_text`) VALUES( 'test', 'test' ), ( 'test2', 'test3' ), ( 'test4', 'test4' ) ";
//
//if ( mysql_query( $sql ) )
//{
//  if ( $rows = mysql_affected_rows(  ) )
//    echo $rows . ' Added';
//  else
//    echo 'No affected';
//}
//else
//  echo mysql_error(  );


//exit;

//
//mysql_query( "START TRANSACTION" );
//
//$sql = "DELETE FROM `blog` WHERE `id` = '1'  ";
//mysql_query( $sql );
//
//
//$sql = "DELETE FROM `blog` WHERE `id` = '1'  ";
//mysql_query( $sql );
//
////fatal
//
//$sql = "DELETE FROM `blog` WHERE `id` = '1'  ";
//mysql_query( $sql );
//
//
//$sql = "DELETE FROM `blog` WHERE `id` = '1'  ";
//mysql_query( $sql );
//
//
//
//
//if ( true )
//  mysql_query( "COMMIT" );
//else
//  mysql_query ( "ROLLBACK" );
//
//
//
//$sql = "DELETE FROM `blog` WHERE `id` = '1'  ";
//
//if ( mysql_query( $sql ) )
//{
//  if ( $rows = mysql_affected_rows(  ) )
//    echo $rows;
//  else
//    echo 'No affected';
//}
//else
//  exit( mysql_error(  ) );
//
//
//$sql = "SELECT * FROM `blog`";
//
//if ( $result = mysql_query( $sql ) )
//{
//  if ( mysql_num_rows( $result ) )
//  {
//    while ( $row = mysql_fetch_assoc( $result ) )
//    {
//      echo '<pre>';
//      print_r($row);
//      echo '</pre>';
//      exit(  );
//      echo "{$row['title']} === {$row['text']}<hr />";
//    }
//  }
//  else
//    echo 'No data';
//}
//else
//  echo mysql_error(  );