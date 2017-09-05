<?php
require 'validate.php';

class Multiple extends ValidateAbstract
{
  protected $_type = ValidateAbstract::TYPE_ARRAY;

  public function check( $data )
  {
    if ( [] == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( [] ==  $data and false === $this -> _attr['required'] )
      return true;

    foreach ( $data as $row )
    {
      if ( is_array( $row ) )
        return '!Передан многомерный массив. Ошибка передачи данных' ;

      if ( ! in_array( (string)$row, $this -> _attr['values'] ) )
        return '!Один из переданных отмеченных вариантов списка не найден в нем' ;
    }

    return true;
  }
}

class Oon extends ValidateAbstract
{
  public function check( $data )
  {
    if ( '' == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( '' ==  $data and false === $this -> _attr['required'] )
      return true;

    if ( '1' !== $data )
      return 'Вы не выбрали чекбокс' ;

    return true;
  }
}

class Email extends ValidateAbstract
{
  public function check( $data )
  {
    if ( '' == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( '' ==  $data and false === $this -> _attr['required'] )
      return true;

    if ( ! filter_var( $data, FILTER_VALIDATE_EMAIL ) )
      return 'E-mail введено не верно. Проверьте правильность ввода адреса.';

    return true;
  }
}

class Password extends ValidateAbstract
{
  public function check( $data )
  {
    if ( '' == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( '' ==  $data and false === $this -> _attr['required'] )
      return true;

    if ( ctype_digit( $data ) )
      return 'Пароли с одних чисел запрещены' ;

    if ( mb_strlen( $data ) < 5 )
      return 'Пароли должен быть болше 5 символов' ;

    return true;
  }
}

class Date extends ValidateAbstract
{
  public function check( $data )
  {
    if ( '' == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( '' ==  $data and false === $this -> _attr['required'] )
      return true;

    if ( ! preg_match( '#^\d{4}-\d{2}-\d{2}$#ui', $data ) )
      return 'Дата имеет не правильный формат. Передайте данные в формате YYYY-mm-dd.' ;

    //9999-99-99 2017-02-31

    list( $year, $month, $day ) = explode( '-', $data );

    if ( false === checkdate( $month, $day, $year ) )
      return 'Дата не существует.' ;

    return true;
  }
}

//$email  = new Field( 'email', 'email' );
//
//var_dump( $email -> validate( Field::METHOD_GET ) );
//
//echo '<pre>';
//print_r($email -> getData());
//echo '</pre>';
//
//echo '<pre>';
//print_r($email -> getError());
//echo '</pre>';



class Int extends ValidateAbstract
{
  protected $_attr = [
    'required'  => true,
    'min'       => -2147483647,
    'max'       => 2147483647,
  ];

  public function check( $data )
  {
    if ( $this -> _attr['required'] === false and $data === '' )
      return true;

    if ( $this -> _attr['required'] === true and $data === '' )
      return 'Вы не передали данные';

    if ( $data < $this -> _attr['min'] )
      return "Ваш текст должен быть минимум {$this -> _attr['min']} символов";

    if ( $data > $this -> _attr['max']  )
      return "Ваш текст должен быть максимум {$this -> _attr['max']} символов";

    return true;
  }
}

////$int = new Field( 'int', 'int' );
//$int = new Field( 'int', 'int', ['min' => -555] );
//
//var_dump( $int -> validate( Field::METHOD_GET ) );
//
//echo '<pre>';
//print_r( $int -> getData() );
//echo '</pre>';
//
//echo '<pre>';
//print_r( $int -> getError() );
//echo '</pre>';





if ( isset( $_POST['submit_test'] ) )
{
  $group = new Group( [
    [ 'text',     'text',    ['maxlength' => 40] ],
    [ 'password', 'password' ],
    [ 'date',     'date' ],
    [ 'radio',    'enum',     ['values' => [1,2]] ],
    [ 'checkbox', 'oon' ],
    [ 'select',   'enum',     ['values' => ['v1', 'v2', 'v3']] ],
    [ 'selectm',  'multiple', ['values' => ['v11', 'v12', 'v13']] ],
    [ 'textarea', 'text', ['textarea' => true] ],
  ] );

  //4
  if ( $group -> isValid(  ) )
  {
    echo 'Виконуємо дію';
    echo '<pre>';
    print_r( $group -> getAllData() );
    echo '</pre>';
  }
  else
  {
    $a_data  = $group -> getAllData();
    $a_error = $group -> getAllError();

    echo '<h1>В даних знайдено помилки:</h1>';

//    foreach ( $a_error as $key => $error )
//      echo "В полі {$key} знайдено помилку: {$error}<br />";
  }
}
?>




<form action="" method="post">
  <input type="text" name="text"
         value="<?= ( isset( $a_data['text'] ) ? htmlspecialchars( $a_data['text'] ) : '' ) ?>" /><br />
<?php //         value="<?= ( $group -> getFieldData( 'text' ) ? htmlspecialchars( $group -> getFieldData( 'text' ) ) : '' ) " /><br /> ?>

  <?= ( ( isset( $a_error['text'] ) ) ? '<span style="color: red">' . $a_error['text'] . '</span><br />' : '' ) ?>
  <?= ''//( ( $group -> getFieldError( 'text' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'text' ) . '</span><br />' : '' ) ?>

  <input type="password" name="password" /><br />
  <?= ( ( isset( $a_error['password'] ) ) ? '<span style="color: red">' . $a_error['password'] . '</span><br />' : '' ) ?>


  <input required="required" type="text" name="date"
         value="<?= ( isset( $a_data['date'] ) ? htmlspecialchars( $a_data['date'] ) : '' ) ?>" /><br />
  <?= ( ( isset( $a_error['date'] ) ) ? '<span style="color: red">' . $a_error['date'] . '</span><br />' : '' ) ?>

  <input type="radio" name="radio" value="1" <?= ( ( isset( $a_data['radio'] ) and $a_data['radio'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <input type="radio" name="radio" value="2" <?= ( ( isset( $a_data['radio'] ) and $a_data['radio'] == 2 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['radio'] ) ) ? '<span style="color: red">' . $a_error['radio'] . '</span><br />' : '' ) ?>


  <input type="checkbox" name="checkbox" value="1"<?= ( ( isset( $a_data['checkbox'] ) and $a_data['checkbox'] == 1 ) ? ' checked="checked"' : '' ) ?>/><br />
  <?= ( ( isset( $a_error['checkbox'] ) ) ? '<span style="color: red">' . $a_error['checkbox'] . '</span><br />' : '' ) ?>

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

  <input type="submit" name="submit_test" value="SEND" />
</form>

