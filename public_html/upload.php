<?php

if ( isset( $_POST['upload'] ) )
{
  $a_data = $a_error = [ ];

  //1
  $a_data['myfile'] = ( isset( $_FILES['myfile'] ) ) ? $_FILES['myfile'] : [];

  //2
  if ( $a_data['myfile'] == [] )
    $a_error['myfile'] = 'Нет файла';

  else if ( $a_data['myfile']['error'] != 0 )
  {
    switch ( $a_data['myfile']['error'] )
    {
      case 1 : $a_error['myfile'] = 'Ваш файл слишком большой#1'; break;
      case 2 : $a_error['myfile'] = 'Ваш файл слишком большой#2'; break;
      case 3 : $a_error['myfile'] = 'Error #3'; break;
      case 4 : $a_error['myfile'] = 'Выберите файл для загрузки. Файл не выбран'; break;
      case 6 : $a_error['myfile'] = 'Error #6'; break;
      case 7 : $a_error['myfile'] = 'Случилась системная ошибка. Попробуйте загрузить файл позже'; break;
      case 8 : $a_error['myfile'] = 'Error #8'; break;
    }
  }

  else if ( $a_data['myfile']['size'] > 2*1024*1024 )
    $a_error['myfile'] = 'Файл слишком большой. Максимально 2 метра';

  else
  {
    $a_ext = [ 'png', 'jpeg', 'jpg' ];
    $ext = mb_strtolower( pathinfo( $a_data['myfile']['name'], PATHINFO_EXTENSION ) );

    if ( ! in_array( $ext, $a_ext ) )
      $a_error['myfile'] = 'Данный файл не разрешается к загрузке. ';

    else if ( false === $image = getimagesize( $a_data['myfile']['tmp_name'] ) )
      $a_error['myfile'] = 'Данный файл не есть картинкой';

    else if ( $image[0] > 8000 or $image[1] > 6000 )
      $a_error['myfile'] = 'Максимальный размер фото 8000х6000';
  }

  //
  if ( $a_error == [] )
  {
    move_uploaded_file(
      $a_data['myfile']['tmp_name'],
      $_SERVER['DOCUMENT_ROOT'] . '/upload/' . mb_substr( md5( $a_data['myfile']['name'] . microtime(  ) ), 0, 10 ) . '.' . $ext
      //$_SERVER['DOCUMENT_ROOT'] . '/upload/' . addslashes( $a_data['myfile']['name'] )
    );

    exit( header( 'Location: upload.php' ) );
  }
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="myfile" /><br />
  <!--<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />-->
  <?= ( ( isset( $a_error[ 'myfile' ] ) ) ? '<span style="color: red">' . $a_error[ 'myfile' ] . '</span><br />' : '' ) ?>
  <input type="submit" name="upload" value="Upload file" />
</form>

<?php
foreach ( (array)glob( 'upload/*' ) as $file )
  echo '<img src="' . $file . '" height="200" />';
?>