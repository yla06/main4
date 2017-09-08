<?php
$sql = "SELECT * FROM `sm_category`";

$a_category = [];

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row          = mysql_fetch_assoc( $result ) )
      $a_category[] = $row;
  }
}

$group = new Group( [
  [ 'category_name', 'text', ['maxlength' => 30] ],
  [ 'token', 'token' ],
] );

if ( isset( $_POST['submit_category_add'] ) )
{
  if ( $group -> isValid( Field::METHOD_POST )  )
  {
    $sql = "INSERT INTO `sm_category` SET `category_name` = '" . mysql_real_escape_string( $group -> getFieldData( 'category_name' ) ) . "' ";

    if ( mysql_query( $sql ) )
    {
      if ( $rows = mysql_affected_rows(  ) )
      {
        setSuccess( 'Категория успешно создана' );
        exit( header( 'Location: ?module=category' ) );
      }
      else
        setError( 'Категория НЕ создана. Попробуйте еще раз' );
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
        <h1 class="collection-title"><span>Создать категорию</span></h1>
        <?php load_template( 'admin_bread' ) ?>
        <form action="" method="post">
          <?= ( ( $group -> getFieldError( 'token' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'token' ) . '</span><br />' : '' ); ?>
          <?= ( ( $group -> getFieldError( 'category_name' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'category_name' ) . '</span><br />' : '' ); ?>
          <input type="text" name="category_name" id="category_name" class="text" value="<?= ( ( $group -> getFieldData( 'category_name' ) ) ? htmlspecialchars( $group -> getFieldData( 'category_name' ) ) : '' ); ?>">
          <input type="hidden" name="token" value="<?= session_id() ?>">

          <input class="btn" name="submit_category_add" type="submit" value="Создать">
        </form>
						</div>
    </div>
  </div>
</section>
<div id="wish-list">
  <div class="container">
    <div class="row">
						<div id="col-main" class="clearfix">
        <div class="page">
          <div class="table-cart">
            <div class="wrap-table">




              <table class="cart-items haft-border">
                <thead>
                  <tr class="top-labels">
                    <th class="text-left">ID</th>
                    <th>Название категории</th>
                    <th>Действия</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ( $a_category as $row ): ?>
                  <tr class="item wishlist-item">
                    <td class="title text-left"><?= intval( $row['category_id'] )?></td>
                    <td class="price title-1"><?= htmlspecialchars( $row['category_name'] )?></td>
                    <td class="remove">
                      <div>
                        <div class="product-remove">
                          <a title="Удалить" class="color-red icon icon-clear" href="?module=category_delete&category_id=<?= intval( $row['category_id'] )?>&token=<?= session_id() ?>">
                            <i class="fa fa-close"></i>
                          </a>
                          <a title="Редактировать" class="color-red icon icon-clear" href="?module=category_edit&category_id=<?= intval( $row['category_id'] )?>">
                            <i class="fa fa-edit"></i>
                          </a>
                        </div>
                      </div>
                    </td>

                  </tr>
                  <?php endforeach?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
						</div>
    </div>
  </div>
</div>