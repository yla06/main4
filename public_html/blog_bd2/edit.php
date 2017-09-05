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

$a_data = [];
$sql    = "SELECT * FROM `" . DB_PREFIX . "blog` WHERE
  `blog_user_id` = '{$_SESSION['auth']}'
  AND `blog_id` = '{$blog_id}' ";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $a_data = mysql_fetch_assoc( $result );
}
else
  exit( mysql_error (  ) );

if ( $a_data == [] )
{
  setWarning( 'ID блога не найден' );
  exit( header( 'Location: index.php' ) );
}


if ( isset( $_POST['submit_edit'] ) )
{
  $a_data = $a_error = [ ];

  $a_data['blog_title'] = ( isset( $_POST['blog_title'] ) and is_string( $_POST['blog_title'] ) )
    ? trim( $_POST['blog_title'] ) : '';

  $a_data['blog_text'] = ( isset( $_POST['blog_text'] ) and is_string( $_POST['blog_text'] ) )
    ? trim( $_POST['blog_text'] ) : '';

  $a_data['token'] = ( isset( $_POST['token'] ) and is_string( $_POST['token'] ) )
    ? trim( $_POST['token'] ) : '';

  if ( $a_data['token'] != session_id(  ) )
    $a_error['token'] = 'Токен не найден.';

  if ( ! $a_data['blog_title'] )
    $a_error['blog_title'] = 'Дані не введено.';

  else if ( mb_strlen( $a_data['blog_title'] ) > 50 )
    $a_error['blog_title'] = 'Заголовок должен быть короче 50 символов.';

  if ( ! $a_data['blog_text'] )
    $a_error['blog_text'] = 'Дані не введено.';

  else if ( mb_strlen( $a_data['blog_text'] ) > 50000 )
    $a_error['blog_text'] = 'Заголовок должен быть короче 50 символов.';

  if ( $a_error == [] )
  {
    $sql = "UPDATE `" . DB_PREFIX . "blog`
      SET
        `blog_title` = '{$a_data['blog_title']}',
        `blog_text`  = '{$a_data['blog_text']}'
      WHERE
        `blog_id` = '{$blog_id}' ";

    if ( mysql_query( $sql ) )
    {
      if ( mysql_affected_rows() )
      {
        setSuccess ( 'Данные блога отредарованы' );
        exit( header( 'Location: index.php' ) );
      }
      else
        setError ( 'Запись не отредактирована' );
    }
    else
      setError ( 'Ой. Попробуйте позже' );
  }
}
?>
<form action="" method="post">
  <label>Заголовок</label><br />
  <input type="text" name="blog_title"
         value="<?= ( isset( $a_data['blog_title'] ) ? htmlspecialchars( $a_data['blog_title'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['blog_title'] ) ) ? '<span style="color: red">' . $a_error['blog_title'] . '</span><br />' : '' ) ?>

  <label>Текст записи</label><br />
  <textarea name="blog_text"><?= ( isset( $a_data['blog_text'] ) ? htmlspecialchars( $a_data['blog_text'] ) : '' ) ?></textarea><br />
  <?= ( ( isset( $a_error['blog_text'] ) ) ? '<span style="color: red">' . $a_error['blog_text'] . '</span><br />' : '' ) ?>

  <?= ( ( isset( $a_error['token'] ) ) ? '<span style="color: red">' . $a_error['token'] . '</span><br />' : '' ) ?>

  <input type="hidden" name="token" value="<?= session_id(  ) ?>" />

  <input type="submit" name="submit_edit" value="Редактировать" />
</form>