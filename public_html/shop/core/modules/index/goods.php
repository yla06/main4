<?php
$gid = new Field( 'goods_id', 'id' );

if ( false === $gid -> validate( Field::METHOD_GET ) )
{
  setError( 'ID товара не передан' );
  exit( header( 'Location: ?module=index' ) );
}

$sql = "SELECT * FROM `sm_goods` WHERE `goods_id` = '" . intval( $gid -> getData() ) . "' LIMIT 1";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
    $a_data = mysql_fetch_assoc( $result );
  else
  {
    setError( 'ID товара не найден' );
    exit( header( 'Location: ?module=index' ) );
  }
}
else
{
  setError( 'ID товара не найден' );
  exit( header( 'Location: ?module=index' ) );
}
?>


<section class="product-detail-content">
				<div class="detail-content-wrapper">
					<div class="container">
						<div class="row">
							<div id="shopify-section-product-template" class="shopify-section">
								<div class="detail-content-inner">

									<div id="product" class="neque-porro-quisquam-est-qui-dolor-ipsum-quia-9 detail-content">
										<div class="col-md-12 info-detail-pro clearfix">
											<div class="col-md-5" id="product-image">
												<div class="show-image-load" style="display: none;">
													<div class="show-image-load-inner">
														<i class="fa fa-spinner fa-pulse fa-2x"></i>
													</div>
												</div>
												<div id="featuted-image" class="image featured">
													<div class="image-item">
														<a href="upload/goods/<?= intval( $a_data['goods_id'] ) ?>/<?= $a_data['goods_image'] ?>" class="thumbnail" id="thumbnail-product-1" data-toggle="modal" data-target="#lightbox">
															<img src="upload/goods/<?= intval( $a_data['goods_id'] ) ?>/<?= $a_data['goods_image'] ?>" alt="<?= htmlspecialchars( $a_data['goods_name'] ) ?>" data-item="1">
														</a>
														<span class="image-title-zoom" data-zoom="thumbnail-product-1">
															<i class="fa fa-search-plus"></i>
															Сделать больше
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-7" id="product-information">
												<h1 itemprop="name" class="title"><?= htmlspecialchars( $a_data['goods_name'] ) ?></h1>

												<form id="add-item-form" action="#" method="post" class="variants">
													<div class="product-options " itemprop="offers">
														<div class="vendor-type">
															<span class="product_vendor"><span class="_title">Остаток:</span> <?= intval( $a_data['goods_rest'] )?></span>
														</div>
														<div class="rating-star">
															<span class="spr-badge" data-rating="0.0"><span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i></span><span class="spr-badge-caption">2 reviews</span>
															</span>
														</div>

														<div class="product-price">
															<meta itemprop="price" content="<?= intval( $a_data['goods_price'] ) ?>">
															<h2 class="price" id="price-preview"><span class="money"><?= intval( $a_data['goods_price'] ) ?></span></h2>
														</div>
														<div class="purchase-section multiple">
															<div class="quantity-wrapper clearfix">
																<div class="wrapper">
																	<input id="quantity" type="text" name="quantity" value="1" maxlength="5" size="5" class="item-quantity">
																</div>
															</div>
															<div class="purchase">
																<button id="add-to-cart" class="btn add-to-cart" type="submit" name="add"><i class="fa fa-shopping-bag"></i>В корзину</button>
															</div>
														</div>
													</div>
												</form>


											</div>
										</div>
										<div id="tabs-information" class="col-md-12">
											<div class="information_content panel panel-default">
												<div class="panel-heading" role="tab" id="heading_des">
													<h4 class="panel-title" data-toggle="collapse" href="#collapse_des" aria-expanded="true" aria-controls="collapse_des">
														Описание
														<i class="fa-icon fa fa-angle-up"></i>
													</h4>
												</div>
												<div id="collapse_des" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_des">
													<div class="panel-body">
														<p><?= nl2br( htmlspecialchars( $a_data['goods_desc'] ) ) ?></p>
													</div>
												</div>
											</div>

											<div class="information_content panel panel-default">
												<div class="panel-heading" role="tab" id="heading_review">
													<h4 class="panel-title" data-toggle="collapse" href="#collapse_review" aria-expanded="true" aria-controls="collapse_review">
														Review
														<i class="fa-icon fa fa-angle-up"></i>
													</h4>
												</div>
												<div id="collapse_review" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_review">
													<div class="panel-body">
														<div id="customer_review">
															<div class="preview_content">
																<div id="shopify-product-reviews" data-id="6537875078">
																	<div class="spr-container">
																		<div class="spr-header">
																			<h2 class="spr-header-title">Customer Reviews</h2>
																			<div class="spr-summary" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
																				<meta itemprop="itemreviewed" content="Chanel, the cheetah">
																				<meta itemprop="votes" content="1">
																				<span itemprop="rating" itemscope="" itemtype="http://data-vocabulary.org/Rating" class="spr-starrating spr-summary-starrating">
																					<meta itemprop="average" content="5.0">
																					<meta itemprop="best" content="5">
																					<meta itemprop="worst" content="1">
																					<i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i>
																				</span>
																				<span class="spr-summary-caption">
																					<span class="spr-summary-actions-togglereviews">Based on 1 review</span>
																				</span>
																				<span class="spr-summary-actions">
																					<a href="#" class="spr-summary-actions-newreview" onclick="active_review_form();return false">Write a review</a>
																				</span>
																			</div>
																		</div>
																		<div class="spr-content">
																			<div class="spr-form" id="form_6537875078" style="display: none;">
																				<form method="post" action="http://demo.designshopify.com/html_sarahmarket/demo/product.html" id="new-review-form_6537875078" class="new-review-form" onsubmit="SPR.submitForm(this);return false;"><input type="hidden" name="review[rating]"><input type="hidden" name="product_id" value="6537875078">
																					<h3 class="spr-form-title">Write a review</h3>
																					<fieldset class="spr-form-contact">
																						<div class="spr-form-contact-name">
																							<label class="spr-form-label" for="review_author_6537875078">Name</label>
																							<input class="spr-form-input spr-form-input-text " id="review_author_6537875078" type="text" name="review[author]" value="" placeholder="Enter your name">
																						</div>
																						<div class="spr-form-contact-email">
																							<label class="spr-form-label" for="review_email_6537875078">Email</label>
																							<input class="spr-form-input spr-form-input-email " id="review_email_6537875078" type="email" name="review[email]" value="" placeholder="john.smith@example.com">
																						</div>
																					</fieldset>
																					<fieldset class="spr-form-review">
																						<div class="spr-form-review-rating">
																							<label class="spr-form-label">Rating</label>
																							<div class="spr-form-input spr-starrating ">
																								<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="1">&nbsp;</a>
																								<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="2">&nbsp;</a>
																								<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="3">&nbsp;</a>
																								<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="4">&nbsp;</a>
																								<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="5">&nbsp;</a>
																							</div>
																						</div>
																						<div class="spr-form-review-title">
																							<label class="spr-form-label" for="review_title_6537875078">Review Title</label>
																							<input class="spr-form-input spr-form-input-text " id="review_title_6537875078" type="text" name="review[title]" value="" placeholder="Give your review a title">
																						</div>
																						<div class="spr-form-review-body">
																							<label class="spr-form-label" for="review_body_6537875078">Body of Review <span class="spr-form-review-body-charactersremaining">(1500)</span></label>
																							<div class="spr-form-input">
																								<textarea class="spr-form-input spr-form-input-textarea " id="review_body_6537875078" data-product-id="6537875078" name="review[body]" rows="10" placeholder="Write your comments here"></textarea>

																							</div>
																						</div>
																					</fieldset>
																					<fieldset class="spr-form-actions">
																						<input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Submit Review">
																					</fieldset>
																				</form>
																			</div>
																			<div class="spr-reviews" id="reviews_6537875078">
																				<div class="spr-review" id="spr-review-7003642">
																					<div class="spr-review-header">
																						<span class="spr-starratings spr-review-header-starratings"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i></span>
																						<h3 class="spr-review-header-title">FRENCH CONNECTION, SUNDAY BLISS BAG</h3>
																						<span class="spr-review-header-byline"><strong>Jin Alkaid</strong> on <strong>Jun 10, 2017</strong></span>
																					</div>
																					<div class="spr-review-content">
																						<p class="spr-review-content-body">FRENCH CONNECTION, SUNDAY BLISS BAG</p>
																					</div>
																					<div class="spr-review-footer">
																						<a href="#" class="spr-review-reportreview" onclick="SPR.reportReview(7003642);return false" id="report_7003642" data-msg="This review has been reported">Report as Inappropriate</a>
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
											<script>
												$(".information_content .panel-title").click(function() {
													if ($(this).find("i").hasClass("fa-angle-up")) {
														$(this).find("i").removeClass("fa-angle-up");
														$(this).find("i").addClass("fa-angle-down");
													} else {
														$(this).find("i").removeClass("fa-angle-down");
														$(this).find("i").addClass("fa-angle-up");
													}
												});
											</script>
										</div>
										<div class="related-products col-sm-12">
											<div class="collection-title home-title page-title"><span>С этим товаром также покупают</span></div>
											<div class="group-related">
												<div class="group-related-inner">
													<div class="rp-slider">

               <?php
               $sql  = "SELECT * FROM `sm_goods` WHERE `goods_id` != '" . intval( $gid -> getData() ) . "' ORDER BY RAND() LIMIT 20 ";

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

               <?php foreach ( $a_products as $product ): ?>
														<div class="content_product">
															<div class="row-container product list-unstyled clearfix">
																<div class="row-left">
																	<a href="?module=goods&goods_id=<?= intval( $product['goods_id'] ) ?>" class="hoverBorder container_item">
																		<div class="hoverBorderWrapper">
																			<img src="upload/goods/<?= intval( $product['goods_id'] ) ?>/<?= $product['goods_image'] ?>" class="not-rotation img-responsive front" alt="<?= htmlspecialchars( $product['goods_name'] )?>">
																			<div class="mask"></div>
																			<img src="upload/goods/<?= intval( $product['goods_id'] ) ?>/<?= $product['goods_image'] ?>" class="rotation img-responsive" alt="<?= htmlspecialchars( $product['goods_name'] )?>">
																		</div>
																	</a>
																	<span class="sale_banner">
																		<span class="sale_text">-66.67%</span>
																	</span>
																	<div class="hover-mask">
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
																							<div class="product-ajax-cart">
																								<span class="overlay_mask"></span>
																								<div data-handle="neque-porro-quisquam-est-qui-dolor-ipsum-quia-11" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
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
                  <div class="product-title"><a class="title-5" href="?module=goods&goods_id=<?= intval( $product['goods_id'] ) ?>"><?= htmlspecialchars( $product['goods_name'] )?></a></div>
																	<div class="rating-star">
																		<span class="spr-badge" data-rating="0.0"><span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span><span class="spr-badge-caption">No reviews</span>
																		</span>
																	</div>
																	<div class="product-price">
																		<span class="price_sale"><span class="money" data-currency-usd="$200.00"><?= intval( $product['goods_price'] ) ?></span></span>
																	</div>
																</div>
															</div>
														</div>
               <?php endforeach ?>
													</div>
												</div>
											</div>
											<!--END -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
							function active_review_form(){
								if($("#form_6537875078").attr('style')=='display: none;'){
									$("#form_6537875078").css('display','block');
								}
								else {
									$("#form_6537875078").css('display','none');
								}
							}
							jQuery(document).ready(function($){
								$('#gallery-images div.image').on('click', function() {
									var $this = $(this);
									var parent = $this.parents('#gallery-images');
									parent.find('.image').removeClass('active');
									$this.addClass('active');
								});
							});
						</script>
					</div>
				</div>
			</section>