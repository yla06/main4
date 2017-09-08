<?php
$cid  = new Field( 'goods_id', 'id' );

if ( false === $cid -> validate( Field::METHOD_GET ) )
{
  setError( 'ID товара не передан' );
  exit( header( 'Location: ?module=goods' ) );
}

$sql = "SELECT * FROM `sm_goods` WHERE `goods_id` = '" . intval( $cid -> getData() ) . "' LIMIT 1";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $a_data = mysql_fetch_assoc( $result );
  else
  {
    setError( 'ID товара не найден' );
    exit( header( 'Location: ?module=goods' ) );
  }
}
else
{
  setError( 'ID товара не найден' );
  exit( header( 'Location: ?module=goods' ) );
}











$sql = "SELECT * FROM `sm_category`";

$a_category = [];

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row = mysql_fetch_assoc( $result ) )
      $a_category[$row['category_id']] = $row['category_name'];
  }
}

$group = new Group( [
  [ 'goods_category_id', 'enum', ['values' => array_keys( $a_category ) ] ],
  [ 'goods_name', 'text', ['maxlength' => 30] ],
  [ 'goods_image', 'image' ],
  [ 'goods_price', 'price' ],
  [ 'goods_rest', 'int',  ['min' => 0, 'max' => 1000] ],
  [ 'goods_desc', 'text', ['maxlength' => 65000, 'textarea' => true] ],
  [ 'goods_weight', 'int', ['min' => 0, 'max' => 9] ],

  [ 'token', 'token' ],
] );


$group -> fill( $a_data );

if ( isset( $_POST['submit_goods_edit'] ) )
{
  if ( $group -> isValid( Field::METHOD_POST )  )
  {
    $tmp_name = mb_substr( md5( $group -> getFieldData( 'goods_image' )['name'] . microtime(  ) ), 0, 10 );
    $tmp_name .= "." . pathinfo( $group -> getFieldData( 'goods_image' )['name'], PATHINFO_EXTENSION );

    $sql = "UPDATE `sm_goods` SET
        `goods_category_id` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_category_id' ) ) . "',
        `goods_name` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_name' ) ) . "',
        `goods_image` = '{$tmp_name}',
        `goods_price` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_price' ) ) . "',
        `goods_rest` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_rest' ) ) . "',
        `goods_desc` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_desc' ) ) . "',
        `goods_weight` = '" . mysql_real_escape_string( $group -> getFieldData( 'goods_weight' ) ) . "'
      WHERE `goods_id` = '" . intval( $cid -> getData() ) . "' LIMIT 1
        ";

    if ( mysql_query( $sql ) )
    {
      if ( $rows = mysql_affected_rows(  ) )
      {
        $save_path = MC_ROOT . '/upload/goods/' . $cid -> getData();

        mkdir( $save_path, 0777, true );

        move_uploaded_file(
          $group -> getFieldData( 'goods_image' )['tmp_name'],
          "{$save_path}/{$tmp_name}"
        );

        setSuccess( 'Товар успешно отредатирован' );
        exit( header( 'Location: ?module=goods' ) );
      }
      else
        setError( 'Товар НЕ отредатирован. Попробуйте еще раз' );
    }
    else
      setError( 'Товар с таким именем уже существует' );
  }
  else
    setError ( 'В данных найдены ошибки' );
}
?>


<section class="collection-heading heading-content ">
  <div class="container">
    <div class="row">
						<div class="collection-wrapper">
        <h1 class="collection-title"><span>Редактировать товар</span></h1>

        <?php load_template( 'admin_bread' ) ?>

        <form action="" method="post" enctype="multipart/form-data">
          <?= ( ( $group -> getFieldError( 'token' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'token' ) . '</div>' : '' ); ?>
          <div class="row">
            <div class="col-md-3">
              <label for="note">Категория</label>
              <select name="goods_category_id" class="select">
                <?php foreach ( $a_category as $id => $name ): ?>
                  <option value="<?= $id ?>"<?= ( ( $group -> getFieldData( 'goods_category_id' ) == $id ) ? ' selected="selected"' : '' ) ?>><?= $name ?></option>
                <?php endforeach ?>
              </select>
              <?= ( ( $group -> getFieldError( 'goods_category_id' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_category_id' ) . '</div>' : '' ); ?>
            </div>

            <div class="col-md-3">
              <label for="note">Название товара</label>
              <input type="text" name="goods_name" id="goods_name" class="text" value="<?= ( ( $group -> getFieldData( 'goods_name' ) ) ? htmlspecialchars( $group -> getFieldData( 'goods_name' ) ) : '' ); ?>">
              <?= ( ( $group -> getFieldError( 'goods_name' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_name' ) . '</div>' : '' ); ?>
            </div>

            <div class="col-md-3">
              <label for="note">Цена</label>
              <input type="text" name="goods_price" id="goods_price" class="text" value="<?= ( ( $group -> getFieldData( 'goods_price' ) ) ? htmlspecialchars( $group -> getFieldData( 'goods_price' ) ) : '' ); ?>">
              <?= ( ( $group -> getFieldError( 'goods_price' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_price' ) . '</div>' : '' ); ?>
            </div>

            <div class="col-md-3">
              <label for="note">Остаток</label>
              <input type="text" name="goods_rest" id="goods_rest" class="text" value="<?= ( ( $group -> getFieldData( 'goods_rest' ) ) ? htmlspecialchars( $group -> getFieldData( 'goods_rest' ) ) : '' ); ?>">
              <?= ( ( $group -> getFieldError( 'goods_rest' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_rest' ) . '</div>' : '' ); ?>
            </div>

          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="note">Рейтинг(0-9)</label>
              <input type="text" name="goods_weight" id="goods_weight" class="text" value="<?= ( ( $group -> getFieldData( 'goods_weight' ) ) ? htmlspecialchars( $group -> getFieldData( 'goods_weight' ) ) : '0' ); ?>">
              <?= ( ( $group -> getFieldError( 'goods_weight' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_weight' ) . '</div>' : '' ); ?>
            </div>

            <div class="col-md-4">
              <label for="note">Изображение товара</label>
              <input type="file" name="goods_image" id="goods_image" class="file" />
              <?= ( ( $group -> getFieldError( 'goods_image' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_image' ) . '</div>' : '' ); ?>
            </div>

            <div class="col-md-2">
              <img class="img img-responsive" src="upload/goods/<?= $a_data['goods_id'] ?>/<?= $a_data['goods_image'] ?>">
            </div>

            <div class="col-md-12">
              <label for="note">Описание</label>
              <textarea class="textarea" name="goods_desc" id="goods_desc"><?= ( ( $group -> getFieldData( 'goods_desc' ) ) ? htmlspecialchars( $group -> getFieldData( 'goods_desc' ) ) : '' ); ?></textarea>
              <?= ( ( $group -> getFieldError( 'goods_desc' ) ) ? '<div class="alert alert-danger">' . $group -> getFieldError( 'goods_desc' ) . '</div>' : '' ); ?>
            </div>
          </div>



          <input type="hidden" name="token" value="<?= session_id() ?>">
          <div class="col-md-12">
          <input class="btn" name="submit_goods_edit" type="submit" value="Редактировать">
          </div>
        </form>
						</div>
    </div>
  </div>
</section>