<?php

require_once 'bootstrap.php';
$action = ( isset( $_REQUEST[ 'action' ] ) and is_string( $_REQUEST[ 'action' ] ) ) ? $_REQUEST[ 'action' ] : '';

if ( $action == 'index_json' )
{
  $sql = "SELECT * FROM `" . DB_PREFIX . "blog`";

  if ( $result = mysql_query( $sql ) )
  {
    $data = [ ];

    while ( $row    = mysql_fetch_assoc( $result ) )
      $data[] = $row;

    return_data( $data );
  }
  else
    return_error( 'SQL ошибка' );
}

else if ( $action == 'edit' )
{
  if ( ! isset( $_SESSION[ 'auth' ] ) )
    return_error ( 'Нет авторизации' );

  $a_data  = $a_error = [ ];
  $a_data[ 'blog_id' ]    = ( isset( $_POST[ 'blog_id' ] ) and is_string( $_POST[ 'blog_id' ] ) ) ? trim( $_POST[ 'blog_id' ] ) : '';
  $a_data[ 'blog_title' ] = ( isset( $_POST[ 'blog_title' ] ) and is_string( $_POST[ 'blog_title' ] ) ) ? trim( $_POST[ 'blog_title' ] ) : '';
  $a_data[ 'blog_text' ]  = ( isset( $_POST[ 'blog_text' ] ) and is_string( $_POST[ 'blog_text' ] ) ) ? trim( $_POST[ 'blog_text' ] ) : '';
  $a_data[ 'token' ]      = ( isset( $_POST[ 'token' ] ) and is_string( $_POST[ 'token' ] ) ) ? trim( $_POST[ 'token' ] ) : '';

  if ( $a_data[ 'token' ] != session_id() )
    $a_error[ 'token' ] = 'Токен не найден.';

  if ( ! $a_data[ 'blog_id' ] )
    $a_error[ 'blog_id' ] = 'Дані не введено.';

  if ( ! $a_data[ 'blog_title' ] )
    $a_error[ 'blog_title' ] = 'Дані не введено.';

  else if ( mb_strlen( $a_data[ 'blog_title' ] ) > 50 )
    $a_error[ 'blog_title' ] = 'Заголовок должен быть короче 50 символов.';

  if ( ! $a_data[ 'blog_text' ] )
    $a_error[ 'blog_text' ] = 'Дані не введено.';

  else if ( mb_strlen( $a_data[ 'blog_text' ] ) > 50000 )
    $a_error[ 'blog_text' ] = 'Заголовок должен быть короче 50 символов.';

  if ( $a_error == [ ] )
  {
    $sql = "UPDATE `" . DB_PREFIX . "blog`
      SET
        `blog_title` = '{$a_data[ 'blog_title' ]}',
        `blog_text`  = '{$a_data[ 'blog_text' ]}'
      WHERE
        `blog_id` = '{$a_data[ 'blog_id' ]}' ";

    if ( mysql_query( $sql ) )
    {
      if ( mysql_affected_rows() )
        return_data( 'Данные блога изменены' );
      else
        return_error( 'Запись не отредактирована' );
    }
    else
      return_error( 'Ой. Попробуйте позже' );
  }
  else
    return_error( 'В форме найдены ошибки:', $a_error );
}

else if ( $action == 'add' )
{
  if ( ! isset( $_SESSION[ 'auth' ] ) )
    return_error( 'Нет авторизации' );

  $a_data  = $a_error = [ ];
  $a_data[ 'blog_title' ] = ( isset( $_POST[ 'blog_title' ] ) and is_string( $_POST[ 'blog_title' ] ) ) ? trim( $_POST[ 'blog_title' ] ) : '';
  $a_data[ 'blog_text' ] = ( isset( $_POST[ 'blog_text' ] ) and is_string( $_POST[ 'blog_text' ] ) ) ? trim( $_POST[ 'blog_text' ] ) : '';
  $a_data[ 'token' ] = ( isset( $_POST[ 'token' ] ) and is_string( $_POST[ 'token' ] ) ) ? trim( $_POST[ 'token' ] ) : '';

  if ( $a_data[ 'token' ] != session_id() )
    $a_error[ 'token' ] = 'Токен не найден.';

  if ( ! $a_data[ 'blog_title' ] )
    $a_error[ 'blog_title' ] = 'Дані не введено.';

  else if ( mb_strlen( $a_data[ 'blog_title' ] ) > 50 )
    $a_error[ 'blog_title' ] = 'Заголовок должен быть короче 50 символов.';

  if ( ! $a_data[ 'blog_text' ] )
    $a_error[ 'blog_text' ] = 'Дані не введено.';

  else if ( mb_strlen( $a_data[ 'blog_text' ] ) > 50000 )
    $a_error[ 'blog_text' ] = 'Заголовок должен быть короче 50 символов.';

  if ( $a_error == [ ] )
  {
    $sql = "INSERT INTO `" . DB_PREFIX . "blog` SET
      `blog_user_id` = '" . mysql_real_escape_string( $_SESSION[ 'auth' ] ) . "',
      `blog_title` = '" . mysql_real_escape_string( $a_data[ 'blog_title' ] ) . "',
      `blog_text`  = '" . mysql_real_escape_string( $a_data[ 'blog_text' ] ) . "'";

    if ( mysql_query( $sql ) )
    {
      if ( mysql_affected_rows() )
      {
        $a_data[ 'blog_id' ] = mysql_insert_id();
        return_data( 'Сообщение добавлено', $a_data );
      }
      else
        return_error( 'Запись не добавлена' );
    }
    else
      return_error( 'Ой. Попробуйте позже' . mysql_error() );
  }
  else
    return_error( 'В форме найдены ошибки:', $a_error );
}

else if ( $action == 'delete' )
{
  if ( ! isset( $_SESSION[ 'auth' ] ) )
    return_error( 'Нет авторизации' );

  $blog_id = ( isset( $_POST[ 'blog_id' ] ) and is_string( $_POST[ 'blog_id' ] ) and ctype_digit( $_POST[ 'blog_id' ] ) ) ? $_POST[ 'blog_id' ] : false;

  if ( false === $blog_id )
    return_error( 'ID блога не передан' );

  $token = ( isset( $_POST[ 'token' ] ) and is_string( $_POST[ 'token' ] ) ) ? $_POST[ 'token' ] : false;

  if ( $token != session_id() )
    return_error( 'Токен не найден' );

  $sql = "DELETE FROM `" . DB_PREFIX . "blog` WHERE `blog_user_id` = '". intval( $_SESSION['auth']) ."' AND  `blog_id` = '" . intval( $blog_id ) . "' ";

  if ( mysql_query( $sql ) )
  {
    if ( mysql_affected_rows() )
      return_data( 'Запись удаленa' );
    else
      return_error( 'Запись не удалена' );
  }
  else
    return_error( 'Ой. Попробуйте позже' );
}

else if ( $action == 'index' )
{
  $sql = "SELECT * FROM `" . DB_PREFIX . "blog`";

  if ( $result = mysql_query( $sql ) )
  {
    if ( mysql_num_rows( $result ) )
    {
      while ( $row = mysql_fetch_assoc( $result ) )
      {
        echo '<a href="view.php?blog_id=' . $row[ 'blog_id' ] . '">Просмотр</a> |';
        echo '<a href="edit.php?blog_id=' . $row[ 'blog_id' ] . '">Редактировать</a> |';
        echo '<a href="delete.php?blog_id=' . $row[ 'blog_id' ] . '&token=' . session_id() . '">Удалить</a>';
        echo '<br />';
        echo '<h2>' . htmlspecialchars( $row[ 'blog_title' ] ) . '</h2>';
        echo '<div>' . htmlspecialchars( $row[ 'blog_text' ] ) . '</div><hr />';
      }
    }
    else
      echo 'No data';
  }
  else
    exit( mysql_error() );
}

