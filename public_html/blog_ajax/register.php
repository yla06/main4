<?php
require_once 'bootstrap.php';

if ( isset( $_POST['submit_register'] ) )
{
  $a_data = $a_error = [ ];

  //1
  $a_data['user_login'] = ( isset( $_POST['user_login'] ) and is_string( $_POST['user_login'] ) )
    ? trim( $_POST['user_login'] ) : '';

  $a_data['user_password'] = ( isset( $_POST['user_password'] ) and is_string( $_POST['user_password'] ) )
    ? trim( $_POST['user_password'] ) : '';

  //2
  if ( ! $a_data['user_login'] )
    $a_error['user_login'] = 'Логин пуст.';

  if ( ! $a_data['user_password'] )
    $a_error['user_password'] = 'Пароль пуст.';

  // 4
  if ( $a_error == [] )
  {
    $sql = "INSERT INTO `" . DB_PREFIX . "user` SET
      `user_login` = '" . mysql_real_escape_string( $a_data['user_login'] ) . "',
      `user_password`  = '" . md5( $a_data['user_password']  ) . "' ";

    if ( mysql_query( $sql ) )
    {
      if ( mysql_affected_rows() )
      {
        setSuccess ( 'Регистрация успешна' );
        exit( header( 'Location: index.php' ) );
      }
      else
        setError ( 'Запись не добавлена' );
    }
    else
      setError ( 'Ой. Попробуйте позже' );
  }
}
getInfoBlock(  );
?>

<form action="" method="post">
  <label>Логин</label><br />
  <input type="text" name="user_login"
         value="<?= ( isset( $a_data['user_login'] ) ? htmlspecialchars( $a_data['user_login'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['user_login'] ) ) ? '<span style="color: red">' . $a_error['user_login'] . '</span><br />' : '' ) ?>

  <label>Пароль</label><br />
  <input type="password" name="user_password"
         value="<?= ( isset( $a_data['user_password'] ) ? htmlspecialchars( $a_data['user_password'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['user_password'] ) ) ? '<span style="color: red">' . $a_error['user_password'] . '</span><br />' : '' ) ?>

  <input type="submit" name="submit_register" value="Регистрация" />
</form>