<?php
require_once "{$_SERVER[ 'DOCUMENT_ROOT' ]}/model/model/Blog.php";
require_once "{$_SERVER[ 'DOCUMENT_ROOT' ]}/model/model/Comment.php";

//$blog          = new Blog;
////$blog -> id = 2;
////$blog -> title = 'SSSSSSSSSSSSS222222222222';
////$blog -> text  = 'YYYYYYYYYYYYYYY';
////$blog -> save();
//
//$blog -> delete( 2 );
//
//echo '<pre>';
//print_r( Blog::selectAll() );
//echo '</pre>';

DBAbstract::$host = 'localhost';
DBAbstract::$user = 'test1';
DBAbstract::$pass = '12345q';
DBAbstract::$db = 'test1';

$comment = new Comment;
//$comment -> id  = 2;
//$comment -> name  = '3333333333333';
//$comment -> text  = '33333333333';
//var_dump( $comment -> save() );
//var_dump( $comment -> delete( 3 ) );


//echo '<pre>';
//print_r( $comment -> selectAll() );
//echo '</pre>';
//echo '<pre>';
//print_r( $comment -> selectById( 2 ) );
//echo '</pre>';

foreach ( $comment -> selectAll() as $model )
{
  echo '<pre>';
  print_r( $model -> fetch() );
  echo '</pre>';
}