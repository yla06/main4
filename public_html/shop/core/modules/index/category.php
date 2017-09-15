<?php
$cid = new Field( 'category_id', 'id' );

if ( false === $cid -> validate( Field::METHOD_GET ) )
{
  setError( 'ID категории не передан' );
  exit( header( 'Location: ?module=index' ) );
}

$sql = "SELECT * FROM `sm_category` WHERE `category_id` = '" . intval( $cid -> getData() ) . "' LIMIT 1";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $a_data = mysql_fetch_assoc( $result );
  else
  {
    setError( 'ID категории не найден' );
    exit( header( 'Location: ?module=index' ) );
  }
}
else
{
  setError( 'ID категории не найден' );
  exit( header( 'Location: ?module=index' ) );
}

$sql        = "SELECT * FROM `sm_goods` WHERE `goods_category_id` = '" . intval( $cid -> getData() ) . "' ";
$a_products = [];

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row          = mysql_fetch_assoc( $result ) )
      $a_products[] = $row;
  }
}
?>

<section class="collection-content">
  <div class="collection-wrapper">
    <div class="container">
						<div class="row">
        <div id="shopify-section-collection-template" class="shopify-section">
          <div class="collection-inner">
            <!-- Tags loading -->
            <div id="tags-load" style="display:none;"><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
            <div id="collection">
              <div class="collection_inner">


                <div class="collection-mainarea col-sm-12 clearfix">
                  <div class="collection_toolbar">
                    <div class="toolbar_left">
                      Товаров 1 по <?= count( $a_products ) ?> с <?= count( $a_products ) ?> всего
                    </div>
                    <div class="toolbar_right">
                      <div class="group_toolbar">
                        <!-- View as -->
                        <div class="grid_list">
                          <span class="toolbar_title">Select View:</span>
                          <ul class="list-inline option-set hidden-xs" data-option-key="layoutMode">
                            <li data-option-value="fitRows" id="goGrid" class="active goAction " data-toggle="tooltip" data-placement="top" title="" data-original-title="Grid">
                              <i class="fa fa fa-th"></i>
                            </li>
                            <li data-option-value="straightDown" id="goList" class="goAction " data-toggle="tooltip" data-placement="top" title="" data-original-title="List">
                              <i class="fa fa-th-list"></i>
                            </li>
                          </ul>
                        </div>
                        <!-- Sort by -->
                        <div class="sortBy">
                          <span class="toolbar_title">Sort By:</span>
                          <div id="sortButtonWarper" class="dropdown-toggle" data-toggle="dropdown">
                            <button id="sortButton">
                              <span class="name">Featured</span><i class="fa fa-caret-down"></i>
                            </button>
                            <i class="sub-dropdown1"></i>
                            <i class="sub-dropdown"></i>
                          </div>
                          <div id="sortBox" class="control-container dropdown-menu">
                            <ul id="sortForm" class="list-unstyled option-set text-left list-styled" data-option-key="sortBy">
                              <li class="sort manual"><a href="collections-all.html">Featured</a></li>
                              <li class="sort price-ascending"><a href="collections-all.html">Price, low to high</a></li>
                              <li class="sort price-descending"><a href="collections-all.html">Price, high to low</a></li>
                              <li class="sort title-ascending"><a href="collections-all.html">Alphabetically, A-Z</a></li>
                              <li class="sort title-descending"><a href="collections-all.html">Alphabetically, Z-A</a></li>
                              <li class="sort created-ascending"><a href="collections-all.html">Date, old to new</a></li>
                              <li class="sort created-descending"><a href="collections-all.html">Date, new to old</a></li>
                              <li class="sort best-selling"><a href="collections-all.html">Best Selling</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="collection-items clearfix">
                    <div class="products">
                      <?php foreach ( $a_products as $row ): ?>
                      <div class="product-item col-sm-3">
                        <div class="product">
                          <div class="row-left">
                            <a href="?module=goods&goods_id=<?= intval( $row['goods_id'] ) ?>" class="hoverBorder container_item">
                              <div class="hoverBorderWrapper">
                                <img src="upload/goods/<?= intval( $row['goods_id'] ) ?>/<?= $row['goods_image'] ?>" class="not-rotation img-responsive front" alt="<?= htmlspecialchars( $row['goods_name'] ) ?>">
                                <div class="mask"></div>
                                <img src="upload/goods/<?= intval( $row['goods_id'] ) ?>/<?= $row['goods_image'] ?>" class="rotation img-responsive" alt="<?= htmlspecialchars( $row['goods_name'] ) ?>">
                              </div>
                            </a>
                            <div class="hover-mask grid-mode">
                              <div class="group-mask">
                                <div class="inner-mask">
                                  <div class="group-actionbutton">
                                    <form action="#" method="post">
                                      <div class="effect-ajax-cart">
                                        <input type="hidden" name="quantity" value="1">
                                        <button class="btn select-option" type="button"><i class="fa fa-bars"></i></button>
                                      </div>
                                    </form>
                                    <ul class="quickview-wishlist-wrapper">
                                      <li class="quickview hidden-xs hidden-sm">
                                        <div class="product-ajax-cart ">
                                          <span class="overlay_mask"></span>
                                          <div data-handle="seafood-restaurant" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                            <a class=""><i class="fa fa-search" title="Быстрый просмотр"></i></a>
                                          </div>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <!--inner-mask-->
                              </div>
                              <!--Group mask-->
                            </div>
                          </div>
                          <div class="row-right animMix">
                            <div class="grid-mode">
                              <div class="product-title"><a class="title-5" href="?module=goods&goods_id=<?= intval( $row['goods_id'] ) ?>"><?= htmlspecialchars( $row['goods_name'] ) ?></a></div>
                              <div class="rating-star">
                                <span class="spr-badge" data-rating="5.0"><span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i></span><span class="spr-badge-caption">1 review</span>
                                </span>
                              </div>
                              <div class="product-price">
                                <span class="price_sale"><span class="money" data-currency-usd="<?= intval( $row['goods_price'] ) ?>"><?= intval( $row['goods_price'] ) ?></span></span>
                              </div>
                            </div>
                            <div class="list-mode hide">
                              <div class="list-left">
                                <div class="product-title"><a class="title-5" href="?module=goods&goods_id=<?= intval( $row['goods_id'] ) ?>"><?= htmlspecialchars( $row['goods_name'] ) ?></a></div>
                                <div class="rating-star">
                                  <span class="spr-badge" data-rating="5.0"><span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i></span><span class="spr-badge-caption">1 review</span>
                                  </span>
                                </div>
                                <div class="product-description">
                                    <?= htmlspecialchars( $row['goods_desc'] ) ?>
                                </div>
                              </div>
                              <div class="list-right">
                                <div class="product-price">
                                  <span class="price_sale"><span class="money"><?= intval( $row['goods_price'] ) ?></span></span>
                                </div>
                                <div class="product-group-actions">
                                  <form class="product-addtocart" action="#" method="post">
                                    <div class="effect-ajax-cart">
                                      <input type="hidden" name="quantity" value="1">
                                      <button class="btn btn-1 select-option" type="button"><i class="fa fa-bars"></i></button>
                                    </div>
                                  </form>
                                  <ul class="quickview-wishlist-wrapper">
                                    <li class="product-wishlist wishlist">
                                      <a class="wish-list" href="wish-list.html"><span class="hidden-xs"><i class="fa fa-heart" title="Wishlist"></i></span></a>
                                    </li>
                                    <li class="product-quickview quickview hidden-xs hidden-sm">
                                      <div class="product-ajax-cart ">
                                        <span class="overlay_mask"></span>
                                        <div data-handle="seafood-restaurant" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                          <a class=""><i class="fa fa-search" title="Быстрый просмотр"></i></a>
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                  <div class="collection-bottom-toolbar">
                    <div class="product-counter col-sm-6">
                      Items 1 to 16 of 40 total
                    </div>
                    <div class="product-pagination col-sm-6">
                      <div class="pagination_group">
                        <ul class="pagination">
                          <li class="prev"><a href="collections-all.html">Prev</a></li>
                          <li class="active"><a href="collections-all.html">1</a></li>
                          <li><a href="collections-all.html">2</a></li>
                          <li><a href="collections-all.html">3</a></li>
                          <li class="next"><a href="collections-all.html">Next</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>