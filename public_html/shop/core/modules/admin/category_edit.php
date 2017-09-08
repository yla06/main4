<?php
$cid  = new Field( 'category_id', 'id' );

if ( false === $cid -> validate( Field::METHOD_GET ) )
{
  setError( 'ID категории не передан' );
  exit( header( 'Location: ?module=category' ) );
}

$sql = "SELECT * FROM `sm_category` WHERE `category_id` = '" . intval( $cid -> getData() ) . "' LIMIT 1";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $a_data = mysql_fetch_assoc( $result );
  else
  {
    setError( 'ID категории не найден' );
    exit( header( 'Location: ?module=category' ) );
  }
}
else
{
  setError( 'ID категории не найден' );
  exit( header( 'Location: ?module=category' ) );
}

$group = new Group( [
  [ 'category_name', 'text', ['maxlength' => 30] ],
  [ 'token', 'token' ],
] );

$group -> fill( $a_data );

if ( isset( $_POST['submit_category_edit'] ) )
{
  if ( $group -> isValid( Field::METHOD_POST )  )
  {
    $sql = "UPDATE `sm_category` SET
      `category_name` = '" . mysql_real_escape_string( $group -> getFieldData( 'category_name' ) ) . "'
      WHERE `category_id` = '" . intval( $cid -> getData() ) . "' LIMIT 1";

    if ( mysql_query( $sql ) )
    {
      if ( $rows = mysql_affected_rows(  ) )
      {
        setSuccess( 'Категория успешно изменила значения' );
        exit( header( 'Location: ?module=category' ) );
      }
      else
        setError( 'Категория не изменила значения' );
    }
    else
      setError( 'Категория с таким именем уже существует' );
  }
  else
    setError ( 'В данных найдены ошибки' );
}
?>


<section class="collection-heading heading-content ">
  <div class="container">
    <div class="row">
						<div class="collection-wrapper">
        <h1 class="collection-title"><span>Редактировать категорию#<?= htmlspecialchars( $a_data['category_name'] ) ?></span></h1>

        <?php load_template( 'admin_bread' ) ?>

        <form action="" method="post">
          <?= ( ( $group -> getFieldError( 'token' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'token' ) . '</span><br />' : '' ); ?>
          <?= ( ( $group -> getFieldError( 'category_name' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'category_name' ) . '</span><br />' : '' ); ?>
          <input type="text" name="category_name" id="category_name" class="text" value="<?= ( ( $group -> getFieldData( 'category_name' ) ) ? htmlspecialchars( $group -> getFieldData( 'category_name' ) ) : '' ); ?>">
          <input type="hidden" name="token" value="<?= session_id() ?>">

          <input class="btn" name="submit_category_edit" type="submit" value="Редактировать">
        </form>
						</div>
    </div>
  </div>
</section>