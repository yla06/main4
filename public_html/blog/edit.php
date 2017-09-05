<?php
require_once 'bootstrap.php';

if ( ! isset( $_SESSION['auth'] ) )
  exit( header( 'Location: authorize.php' ) );

$data   = unserialize( file_get_contents( 'blog.dat' ) );
$key    = ( isset( $_GET[ 'key' ] ) and is_string( $_GET['key'] ) ) ? $_GET[ 'key' ] : false;

if ( false === $key or ! isset( $data[$key] ) )
  exit( 'Ключ не найден' );

$a_data = $data[ $key ];

if ( isset( $_POST['submit_edit'] ) )
{
  $a_data = $a_error = [ ];

  $a_data['title'] = ( isset( $_POST['title'] ) and is_string( $_POST['title'] ) )
    ? trim( $_POST['title'] ) : '';

  $a_data['text'] = ( isset( $_POST['text'] ) and is_string( $_POST['text'] ) )
    ? trim( $_POST['text'] ) : '';

  if ( ! $a_data['title'] )
    $a_error['title'] = 'Дані не введено.';

  else if ( mb_strlen( $a_data['title'] ) > 50 )
    $a_error['title'] = 'Заголовок должен быть короче 50 символов.';

  if ( ! $a_data['text'] )
    $a_error['text'] = 'Дані не введено.';

  else if ( mb_strlen( $a_data['text'] ) > 50000 )
    $a_error['text'] = 'Заголовок должен быть короче 50 символов.';

  if ( $a_error == [] )
  {
    $data[$key] = $a_data;
    file_put_contents( 'blog.dat', serialize( $data ) );

    exit( header( 'Location: index.php' ) );
  }
}
?>
<form action="" method="post">
  <label>Заголовок</label><br />
  <input type="text" name="title"
         value="<?= ( isset( $a_data['title'] ) ? htmlspecialchars( $a_data['title'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['title'] ) ) ? '<span style="color: red">' . $a_error['title'] . '</span><br />' : '' ) ?>

  <label>Текст записи</label><br />
  <textarea name="text"><?= ( isset( $a_data['text'] ) ? htmlspecialchars( $a_data['text'] ) : '' ) ?></textarea><br />
  <?= ( ( isset( $a_error['text'] ) ) ? '<span style="color: red">' . $a_error['text'] . '</span><br />' : '' ) ?>

  <input type="submit" name="submit_edit" value="Редактировать" />
</form>