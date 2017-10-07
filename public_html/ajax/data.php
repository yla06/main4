<?php
$type = ( isset( $_POST['type'] ) and is_string( $_POST['type'] ) ) ? $_POST['type'] : '';

if ( $type == 'getlist' )
{
  $return = [];

  foreach ( glob( 'files/*' ) as $file )
    $return[pathinfo( $file, PATHINFO_BASENAME )] = file_get_contents( $file );

  exit( json_encode( $return ) );
}

else if ( $type == 'edit' )
{
  //1
  $a_data  = $a_error = [ ];
  $a_data['file_content'] = ( isset( $_POST['file_content'] ) and is_string( $_POST['file_content'] ) ) ? $_POST['file_content'] : '';
  $a_data['file_name']    = ( isset( $_POST['file_name'] )    and is_string( $_POST['file_name'] ) )    ? $_POST['file_name']    : '';

  //2
  if ( empty( $a_data['file_name'] ) )
    $a_error['file_name'] = 'Имя файла для редактирования не передано';

  if ( empty( $a_data['file_content'] ) )
    $a_error['file_content'] = 'Содержимое не введено';

  //3
  if ( ! isset( $a_error['file_name'] ) )
  {
    $file_path = "files/{$a_data['file_name']}";

    if ( ! file_exists( $file_path ) )
      $a_error['file_name'] = 'Файл не существует';
  }

  //4
  if ( $a_error )
    returnError( 'Найдено ошибки', $a_error );

  if ( file_put_contents( $file_path, $a_data['file_content'] ) )
    returnSuccess( 'Файл изменен' );

  returnError( 'Файл не изменен' );
}

else if ( $type == 'delete' )
{
  $a_data  = $a_error = [ ];
  //1
  $a_data['file_name'] = ( isset( $_POST['file_name'] ) and is_string( $_POST['file_name'] ) ) ? $_POST['file_name'] : '';
//2
  if ( empty( $a_data['file_name'] ) )
    $a_error['file_name'] = 'Имя файла для удаления не передано';

  $file_path = "files/{$a_data['file_name']}";
//3
  if ( ! file_exists( $file_path ) )
    $a_error['file_name'] = 'Файл не существует';

  //4
  if ( $a_error )
    returnError( 'Найдено ошибки', $a_error );

  if ( unlink( $file_path ) )
    returnSuccess( 'Файл удален' );

  returnError( 'Файл не удален' );
}

else if ( $type == 'add' )
{
  $a_data  = $a_error = [ ];
  $a_data['file_name'] = ( isset( $_POST['file_name'] ) and is_string( $_POST['file_name'] ) ) ? $_POST['file_name'] : '';
  //2
  if ( empty( $a_data['file_name'] ) )
    $a_error['file_name'] = 'имя не введено';

  $file_path = "files/{$a_data['file_name']}.txt";
  //3
  if ( file_exists( $file_path ) )
    $a_error['file_name'] = 'Файл существует';

  if ( $a_error )
    returnError( 'Найдено ошибки', $a_error );

  if ( file_put_contents( $file_path, '1' ) )
    returnSuccess( 'Файл создан' );

  returnError( 'Файл не создан' );
}

function returnError ( $text, array $array_error = [ ] )
{
  exit( json_encode( [ 'status' => 0, 'info' => $text, 'error' => $array_error ] ) );
}

function returnSuccess ( $text, array $array_data = [ ] )
{
  exit( json_encode( [ 'status' => 1, 'info' => $text, 'data' => $array_data ] ) );
}
