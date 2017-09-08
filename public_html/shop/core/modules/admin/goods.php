<?php
$sql = "SELECT * FROM `sm_goods`";

$a_goods = [];

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row = mysql_fetch_assoc( $result ) )
      $a_goods[] = $row;
  }
}

?>



<section class="collection-heading heading-content ">
  <div class="container">
    <div class="row">
						<div class="collection-wrapper">
        <h1 class="collection-title"><span>Список товара</span></h1>
        <a href="?module=goods_add">Создать товар</a>
        <?php load_template( 'admin_bread' ) ?>

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
                  <?php foreach ( $a_goods as $row ): ?>
                  <tr class="item wishlist-item">
                    <td class="title text-left"><?= intval( $row['goods_id'] )?></td>
                    <td class="price title-1"><?= htmlspecialchars( $row['goods_name'] )?></td>
                    <td class="remove">
                      <div>
                        <div class="product-remove">
                          <a title="Удалить" class="color-red icon icon-clear" href="?module=goods_delete&goods_id=<?= intval( $row['goods_id'] )?>&token=<?= session_id() ?>">
                            <i class="fa fa-close"></i>
                          </a>
                          <a title="Редактировать" class="color-red icon icon-clear" href="?module=goods_edit&goods_id=<?= intval( $row['goods_id'] )?>">
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