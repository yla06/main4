<?php

if ( isset( $_POST['submit-foo'] ) )
{
  $a_data = $a_error = [ ];

  //1
  $a_data['text-field'] = ( isset( $_POST['text-field'] ) and is_string( $_POST['text-field'] ) )
    ? trim( $_POST['text-field'] ) : '';

  $a_data['password-field'] = ( isset( $_POST['password-field'] ) and is_string( $_POST['password-field'] ) )
    ? trim($_POST['password-field']) : '';

  $a_data['checkbox-field'] = ( isset( $_POST['checkbox-field'] ) ) ? 1 : 0;

  $a_data['radio-field'] = ( isset( $_POST['radio-field'] ) and is_string( $_POST['radio-field'] ) )
    ? trim($_POST['radio-field']) : '';

  $a_data['hidden-field'] = ( isset( $_POST['hidden-field'] ) and is_string( $_POST['hidden-field'] ) )
    ? trim($_POST['hidden-field']) : '';

  $a_data['select'] = ( isset( $_POST['select'] ) and is_string( $_POST['select'] ) )
    ? trim($_POST['select']) : '';

  $a_data['selectm'] = ( isset( $_POST['selectm'] ) and is_array( $_POST['selectm'] ) )
    ? $_POST['selectm'] : [];

  $a_data['textarea'] = ( isset( $_POST['textarea'] ) and is_string( $_POST['textarea'] ) )
    ? trim($_POST['textarea']) : '';

  //2
  if ( '' == $a_data['text-field'] )
    $a_error['text-field'] = 'Дані не введено';

  else if ( mb_strlen( $a_data['text-field'] ) > 10 )
    $a_error['text-field'] = 'Строка перевищуэ 10 символів';


  if ( '' == $a_data['password-field'] )
    $a_error['password-field'] = 'Дані не введено';

  else if ( is_numeric( $a_data['password-field'] ) )
    $a_error['password-field'] = 'Пароль не може бути числом';

  else if ( mb_strlen( $a_data['password-field'] ) < 5 )
    $a_error['password-field'] = 'Пароль має бути більше 5 символів';


  if ( 0 === $a_data['checkbox-field'] )
    $a_error['checkbox-field'] = 'Чекбокс потрібно вибрати';


  if ( ! in_array( $a_data['radio-field'], [ 1, 2 ] ) )
    $a_error['radio-field'] = 'Виберіть значення зі списку';


  if ( ! in_array( $a_data['select'], [ 'v1', 'v2', 'v3' ] ) )
    $a_error['select'] = 'Виберіть значення зі списку';

  if ( empty( $a_data['selectm'] ) or array_diff( $a_data['selectm'], [ 'v11', 'v12', 'v13' ] ) )
    $a_error['selectm'] = 'Виберіть значення зі списку або переданий варіант не знайдено';

  if ( '' == $a_data['textarea'] )
    $a_error['textarea'] = 'Дані не введено';

  else if ( mb_strlen( $a_data['textarea'] ) > 1000 )
    $a_error['textarea'] = 'Строка перевищуэ 1000 символів';


  //3
  if ( ! isset( $a_error['text-field'] ) )
  {
    //додаткова перевірка
    /**
     * SQL
     *
     * if ( exists )
     *   $a_error['text-field'] = 'text error';
     */
  }

  //4
  if ( ! $a_error )
  {
    echo 'Виконуємо дію';
    echo '<pre>';
    print_r( $a_data );
    echo '</pre>';
  }
  else
  {
    echo '<h1>В даних знайдено помилки:</h1>';

//    foreach ( $a_error as $key => $error )
//      echo "В полі {$key} знайдено помилку: {$error}<br />";
  }
}
?>
<form action="" method="post">
  <input required="required" maxlength="10" type="text" name="text-field"
         value="<?= ( isset( $a_data['text-field'] ) ? htmlspecialchars( $a_data['text-field'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['text-field'] ) ) ? '<span style="color: red">' . $a_error['text-field'] . '</span><br />' : '' ) ?>

  <input type="password" name="password-field" /><br />
  <?= ( ( isset( $a_error['password-field'] ) ) ? '<span style="color: red">' . $a_error['password-field'] . '</span><br />' : '' ) ?>

  <input type="checkbox" name="checkbox-field" value="1"<?= ( ( isset( $a_data['checkbox-field'] ) and $a_data['checkbox-field'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['checkbox-field'] ) ) ? '<span style="color: red">' . $a_error['checkbox-field'] . '</span><br />' : '' ) ?>

  <input type="radio" name="radio-field" value="1" <?= ( ( isset( $a_data['radio-field'] ) and $a_data['radio-field'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <input type="radio" name="radio-field" value="2" <?= ( ( isset( $a_data['radio-field'] ) and $a_data['radio-field'] == 2 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['radio-field'] ) ) ? '<span style="color: red">' . $a_error['radio-field'] . '</span><br />' : '' ) ?>

  <input type="hidden" name="hidden-field" value="yes,sir" /><br />

  <select name="select">
    <option></option>
    <option value="v1"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v1' ) ? ' selected="selected"' : '' ) ?>>v1</option>
    <option value="v2"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v2' ) ? ' selected="selected"' : '' ) ?>>v2</option>
    <option value="v3"<?= ( ( isset( $a_data['select'] ) and $a_data['select'] == 'v3' ) ? ' selected="selected"' : '' ) ?>>v3</option>
  </select><br />
  <?= ( ( isset( $a_error['select'] ) ) ? '<span style="color: red">' . $a_error['select'] . '</span><br />' : '' ) ?>

  <select name="selectm[]" multiple="multiple">
    <option value="v11"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v11', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v11</option>
    <option value="v12"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v12', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v12</option>
    <option value="v13"<?= ( ( isset( $a_data['selectm'] ) and in_array( 'v13', $a_data['selectm'] ) ) ? ' selected="selected"' : '' ) ?>>v13</option>
  </select><br />
  <?= ( ( isset( $a_error['selectm'] ) ) ? '<span style="color: red">' . $a_error['selectm'] . '</span><br />' : '' ) ?>

  <textarea name="textarea"><?= ( isset( $a_data['textarea'] ) ? $a_data['textarea'] : '' ) ?></textarea><br />
  <?= ( ( isset( $a_error['textarea'] ) ) ? '<span style="color: red">' . $a_error['textarea'] . '</span><br />' : '' ) ?>

  <input type="submit" name="submit-foo" value="SEND" />
</form>


