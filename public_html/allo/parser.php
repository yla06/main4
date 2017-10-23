<?php
require_once 'bootstrap.php';
define( 'HEADTIME', microtime( true ) );
define( 'HEAD_MEMORY_USG', memory_get_usage(  ) );

$n = ( isset( $_GET['n'] ) and is_string( $_GET['n'] ) and ctype_digit( $_GET['n'] ) ) ? $_GET['n'] : 0;

if ( $data_parser['parser_status'] != 'process' )
  stop( 'Парсер не запущен' );

if ( $data_parser['parser_load_category'] == 0 )
{
  if ( $n == 1 )
  {
    $doc = new \DOMDocument( );
    @$doc -> loadHTML( mb_convert_encoding( file_get_contents( 'https://allo.ua/' ), 'HTML-ENTITIES', "UTF-8" ) );
    $xpath = new \DOMXPath( $doc );

//    // 1 level category
//    $list = $xpath -> query( '//li[contains(@class, "level-top")]/div/a' );
//
//    $sql = "INSERT INTO `allo_category` "
//      . "( `category_real_path`, `category_real_name`, `category_real_level`, `category_parser_id` ) VALUES ";
//    $pl = ['parser_id' => $data_parser['parser_id']];
//
//    foreach ( $list as $i => $row )
//    {
//      $sql .= "( :id{$i}, :name{$i}, 1, :parser_id ), ";
//      $pl["id{$i}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
//      $pl["name{$i}"] = trim( $row -> nodeValue );
//    }
//
//    DB::query( rtrim( $sql, ', ' ), $pl );

    // 2 level category
    $list = $xpath -> query( '//a[contains(@class, "level1")]' );

    $sql = "INSERT INTO `allo_category` "
      . "( `category_real_path`, `category_real_name`, `category_real_level`, `category_parser_id` ) VALUES ";
    $pl  = ['parser_id' => $data_parser['parser_id']];

    foreach ( $list as $i => $row )
    {
      $sql            .= "( :id{$i}, :name{$i}, 2, :parser_id ), ";
      $pl[ "id{$i}" ]   = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
      $pl[ "name{$i}" ] = trim( $row -> nodeValue );
    }

    DB::query( rtrim( $sql, ', ' ), $pl );

    // 3 level category
    $list = $xpath -> query( '//a[contains(@class, "level2")]' );

    $sql = "INSERT INTO `allo_category` "
      . "( `category_real_path`, `category_real_name`, `category_real_level`, `category_parser_id` ) VALUES ";
    $pl  = ['parser_id' => $data_parser['parser_id']];

    foreach ( $list as $i => $row )
    {
      $name = trim( $row -> nodeValue );

      if ( 0 === strpos( $name, 'Все' ) )
        continue;

      $sql            .= "( :id{$i}, :name{$i}, 3, :parser_id ), ";
      $pl[ "id{$i}" ]   = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
      $pl[ "name{$i}" ] = $name;
    }

    DB::query( rtrim( $sql, ', ' ), $pl );

    DB::query( "UPDATE `allo_parser` SET `parser_load_category` = 1 WHERE `parser_id` = '{$data_parser['parser_id']}' " );
    exit( 'Category prepared' );
  }
  else
  {
    sleep( 10 );
    exit( 'Wait 10 sec' . $n );
  }
}

else if ( $data_parser['parser_load_category_goods'] == 0 )
{
  $sql = "SELECT * FROM `allo_category` WHERE `category_loaded` = 0 LIMIT 1 ";
  $stm = DB::query( $sql );

  if ( $stm -> rowCount() == 0 )
  {
    DB::query( "UPDATE `allo_parser` SET `parser_load_category_goods` = 1 WHERE `parser_id` = '{$data_parser['parser_id']}' " );
    exit( 'Category goods prepared' );
  }

  $category = $stm -> fetch();
  $url = "https://allo.ua/" . $category['category_real_path'];

  $sql = "INSERT INTO `allo_goods` ( `goods_url`, `goods_category_id`, `goods_parser_id` ) VALUES ";
  $pl = [];
  $page = $curr_page =1;
  $iter = 1;

  do
  {
    $doc = new \DOMDocument( );
    @$doc -> loadHTML( mb_convert_encoding( $a = file_get_contents( $url ), 'HTML-ENTITIES', "UTF-8" ) );
    $xpath = new \DOMXPath( $doc );

    if ( $curr_page == 1 )
    {
      $last = $xpath -> query( '//ol[@class="asd"]/li/a' );

      if ( $last -> length )
      {
        $last_page = $last -> item( $last -> length - 2 );
        $url_page  = $last_page -> getAttribute( 'href' );
        $page      = $last_page -> nodeValue;

        if ( $page > 3 )
          $page = 3;
      }
    }

    $curr_page++;
    $url = 'https:' . preg_replace( '#\/p\-(\d+)\/#', '/p-' . $curr_page . '/', @$url_page );

    $list = $xpath -> query( '//div[contains(@class, "product-container-all")]/p[@class="product-name-container"]/a[@class="product-name"]' );

    foreach ( $list as $row )
    {

      $sql .= "( :url{$iter}, '{$category['category_id']}', '{$data_parser['parser_id']}' ), ";
      $pl["url{$iter}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
      $iter++;
    }
  }
  while( $curr_page <= $page );//

  if ( $pl )
    DB::query( rtrim( $sql, ', ' ), $pl );

  DB::query( "UPDATE `allo_category`
    SET `category_loaded` = 1 WHERE `category_id` = '{$category['category_id']}' ", $pl );


  echo 'Count products: ' . $iter . '<hr />';
//  echo '<pre>';
//  print_r( $pl );
//  echo '</pre>';
}

else if ( $data_parser['parser_load_goods'] == 0 )
{
  DB::getPDO() -> setAttribute( PDO::ATTR_AUTOCOMMIT, 0 );
  DB::getPDO() -> beginTransaction();

  $sql = "SELECT * FROM `allo_goods` WHERE `goods_status` = 0 LIMIT 1 FOR UPDATE";
  $stm = DB::query( $sql );

  if ( ! $stm -> rowCount() )
  {
    DB::query( "UPDATE `allo_parser` SET `parser_load_goods` = 1 WHERE `parser_id` = '{$data_parser['parser_id']}' " );
    DB::getPDO() -> commit();
    exit( 'All goods loaded' );
  }

  $data = $stm -> fetch();

  $sql = "UPDATE `allo_goods` SET `goods_status` = 1 WHERE `goods_id` = :id LIMIT 1";
  $stm = DB::query( $sql, ['id' => $data['goods_id']] );

  DB::getPDO() -> commit();
  DB::getPDO() -> setAttribute( PDO::ATTR_AUTOCOMMIT, 1 );

//  $url = 'https://allo.ua/' . $data['goods_url'];
//
//  $doc = new \DOMDocument( );
//  @$doc -> loadHTML( mb_convert_encoding( $html = file_get_contents( $url ), 'HTML-ENTITIES', "UTF-8" ) );
//  $xpath = new \DOMXPath( $doc );
//
//  $products = [];
//  $products['title'] = trim( $xpath -> query( '//h1[@id="product-title-h1"]' ) -> item ( 0 ) -> nodeValue );
//  $products['price'] = trim( $xpath -> query( '//meta[@itemprop="price"]/@content' ) -> item ( 0 ) -> nodeValue );
//  $products['code'] = str_replace( 'Код товара: ', '', trim( $xpath -> query( '//p[@class="product-ids"]' ) -> item ( 0 ) -> nodeValue ) );
//  $products['images'] = serialize( [] );
//
//  preg_match_all( '#galleryPopupCollection\[(?:\d)*\] = \'(.+)\'#U', $html, $match );
//
//  if ( $match )
//  {
//    $path = "images/{$data['goods_category_id']}/{$data['goods_id']}";
//
//    if ( ! file_exists( $path ) )
//      mkdir( $path, 0777, true );
//
//    $a_pic = [];
//
//    foreach ( (array)$match[1] as $a )
//    {
//      $a_pic[] = pathinfo( $a, PATHINFO_BASENAME );
////      file_put_contents ( $path . '/' . pathinfo( $a, PATHINFO_BASENAME ), file_get_contents ( $a ) );
//    }
//
//    $products['images'] = serialize( $a_pic );
//  }
//
//  $products['id'] = $data['goods_id'];
//  $sql = "UPDATE `allo_goods` SET
//      `goods_title` = :title,
//      `goods_price` = :price,
//      `goods_code` = :code,
//      `goods_images` = :images
//    WHERE `goods_id` = :id";
//  DB::query( $sql, $products );

  exit( 'Product ID: ' . $data['goods_id'] . ' loaded. ' . mf_get_memory() . mf_get_time() );
}

$sql = "UPDATE `allo_parser` SET `parser_status` = 'success' WHERE `parser_id` = '{$data_parser['parser_id']}' ";
DB::query( $sql );
stop( 'Complete' );