<?php
require_once 'bootstrap.php';

$blog_id = ( isset( $_GET[ 'blog_id' ] ) and is_string( $_GET[ 'blog_id' ] ) and ctype_digit( $_GET[ 'blog_id' ] ) ) ? $_GET[ 'blog_id' ] : false;

if ( false === $blog_id )
{
  setWarning( 'ID блога не передан' );
  exit( header( 'Location: index.php' ) );
}

$sql = "SELECT * FROM `" . DB_PREFIX . "blog` WHERE `blog_id` = '{$blog_id}' ";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $row = mysql_fetch_assoc( $result );
  else
  {
    setWarning( 'ID блога не найден' );
    exit( header( 'Location: index.php' ) );
  }
}
else
{
  setWarning( 'ID блога не найден' );
  exit( header( 'Location: index.php' ) );
}

if ( isset( $_SESSION['auth'], $_POST['submit_add_comment'] ) )
{
  $a_data  = $a_error = [];

  $a_data[ 'comment_text' ] = ( isset( $_POST[ 'comment_text' ] ) and is_string( $_POST[ 'comment_text' ] ) ) ? trim( $_POST[ 'comment_text' ] ) : '';
  $a_data[ 'token' ] = ( isset( $_POST[ 'token' ] ) and is_string( $_POST[ 'token' ] ) ) ? trim( $_POST[ 'token' ] ) : '';

  if ( $a_data[ 'token' ] != session_id() )
    $a_error[ 'token' ] = 'Токен не найден.';

  if ( ! $a_data[ 'comment_text' ] )
    $a_error[ 'comment_text' ] = 'Дані не введено.';

  else if ( mb_strlen( $a_data[ 'comment_text' ] ) > 200 )
    $a_error[ 'blog_text' ] = 'Заголовок должен быть короче 200 символов.';

  if ( $a_error == [] )
  {
    $sql = "INSERT INTO `" . DB_PREFIX . "comment`
      SET
        `comment_blog_id` = '{$blog_id}',
        `comment_user_id` = '{$_SESSION[ 'auth' ]}',
        `comment_text`    = '{$a_data[ 'comment_text' ]}'";

    if ( mysql_query( $sql ) )
    {
      if ( mysql_affected_rows() )
      {
        setSuccess( 'Комментарий добавлен' );
        exit( header( 'Location: view.php?blog_id=' . $blog_id ) );
      }
      else
        setError( 'Запись не добавлена' );
    }
    else
      setError( 'Ой. Попробуйте позже' );
  }
  else
    setError( 'В форме найдены ошибки:' );
}

getInfoBlock(  );

if ( isset( $_SESSION['auth'] ) and $_SESSION['auth'] == $row['blog_user_id'] )
{
  echo '<a href="edit.php?blog_id=' . $row[ 'blog_id' ] . '">Редактировать</a> |';
  echo '<a href="delete.php?blog_id=' . $row[ 'blog_id' ] . '&token=' . session_id() . '">Удалить</a><br />';
}

echo '<h2>' . htmlspecialchars( $row[ 'blog_title' ] ) . '</h2>';
echo '<div>' . htmlspecialchars( $row[ 'blog_text' ] ) . '</div><hr />';

$sql = "SELECT *  FROM `" . DB_PREFIX . "comment` WHERE `comment_blog_id` = '{$blog_id}' ";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row = mysql_fetch_assoc( $result ) )
    {
      echo '<h5>' . htmlspecialchars( $row[ 'comment_user_id' ] ) . '</h5>';
      echo '<div>' . htmlspecialchars( $row[ 'comment_text' ] ) . '</div><hr />';
    }
  }
  else
    echo 'комментариев нет';
}
else
  exit( mysql_error() );
?>

<?php if ( isset( $_SESSION[ 'auth' ] ) ): ?>
  <form action="" method="post">
    <label>Текст комента</label><br />
    <textarea name="comment_text"><?= ( isset( $a_data[ 'comment_text' ] ) ? htmlspecialchars( $a_data[ 'comment_text' ] ) : '' ) ?></textarea><br />
  <?= ( ( isset( $a_error[ 'comment_text' ] ) ) ? '<span style="color: red">' . $a_error[ 'comment_text' ] . '</span><br />' : '' ) ?>
    <?= ( ( isset( $a_error[ 'token' ] ) ) ? '<span style="color: red">' . $a_error[ 'token' ] . '</span><br />' : '' ) ?>
    <input type="hidden" name="token" value="<?= session_id() ?>" />
    <input type="submit" name="submit_add_comment" value="Добавить камент" />
  </form>
  <?php
 endif ?>