<?php
require_once 'bootstrap.php';

$sql = "SELECT * FROM `allo_goods` WHERE `goods_status` = 'wait' LIMIT 1";

$result = DB::query( $sql );

$data = $result -> fetch();

$url = 'https://allo.ua/' . $data['goods_url'];

$doc = new \DOMDocument( );
@$doc -> loadHTML( mb_convert_encoding( $html = file_get_contents( $url ), 'HTML-ENTITIES', "UTF-8" ) );
$xpath = new \DOMXPath( $doc );

$products = [];
$products['title'] = trim( $xpath -> query( '//h1[@id="product-title-h1"]' ) -> item ( 0 ) -> nodeValue );
$products['price'] = trim( $xpath -> query( '//meta[@itemprop="price"]/@content' ) -> item ( 0 ) -> nodeValue );
$products['code'] = str_replace( 'Код товара: ', '', trim( $xpath -> query( '//p[@class="product-ids"]' ) -> item ( 0 ) -> nodeValue ) );


preg_match_all( '#galleryPopupCollection\[(?:\d)*\] = \'(.+)\'#U', $html, $match );

$products['images'] = serialize( $match[1] );
$products['id'] = $data['goods_id'];

$sql = "UPDATE `allo_goods` SET
    `goods_title` = :title,
    `goods_price` = :price,
    `goods_code` = :code,
    `goods_images` = :images,
    `goods_status` = 'parsed'
  WHERE `goods_id` = :id LIMIT 1";
DB::query( $sql, $products );

echo '<pre>';
print_r($products);
echo '</pre>';
echo 'Success';