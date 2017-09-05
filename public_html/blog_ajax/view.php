<?php

require_once 'bootstrap.php';

$blog_id = ( isset( $_GET[ 'blog_id' ] ) and is_string( $_GET['blog_id'] ) and ctype_digit( $_GET['blog_id'] ) )
  ? $_GET[ 'blog_id' ]
  : false;

if ( false === $blog_id )
{
  setWarning( 'ID блога не передан' );
  exit( header( 'Location: index.php' ) );
}

$a_blog = [];
$sql    = "SELECT * FROM `" . DB_PREFIX . "blog` WHERE `blog_id` = '{$blog_id}' ";

$result = mysql_query( $sql );
$a_blog = mysql_fetch_assoc( $result );
$a_blog = [];


?>

  <h1><?=  $a_blog['blog_title'] ?></h1>
  <div style="background-color: greenyellow"><?=$a_blog['blog_text']  ?></div>
