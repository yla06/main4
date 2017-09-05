<?php
require_once 'bootstrap.php';

if ( ! isset( $_SESSION['auth'] ) )
  exit( header( 'Location: authorize.php') );

$blog_id = ( isset( $_GET[ 'blog_id' ] ) and is_string( $_GET['blog_id'] ) and ctype_digit( $_GET['blog_id'] ) )
  ? $_GET[ 'blog_id' ]
  : false;

if ( false === $blog_id )
{
  setWarning( 'ID блога не передан' );
  exit( header( 'Location: index.php' ) );
}

$token  = ( isset( $_GET[ 'token' ] ) and is_string( $_GET['token'] ) ) ? $_GET[ 'token' ] : false;

if ( $token != session_id(  ) )
{
  setWarning( 'Токен не найден' );
  exit( header( 'Location: index.php' ) );
}

$sql = "DELETE FROM `" . DB_PREFIX . "blog` WHERE
  `blog_user_id` = '{$_SESSION['auth']}'
  AND `blog_id` = '{$blog_id}' ";

if ( mysql_query( $sql ) )
{
  if ( mysql_affected_rows() )
    setSuccess ( 'Сообщение удалено' );
  else
    setError ( 'Запись не удалена' );
}
else
  setError ( 'Ой. Попробуйте позже' );

exit( header( 'Location: index.php' ) );
