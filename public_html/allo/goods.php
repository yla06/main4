<?php
set_time_limit( 20 );
exit;
require_once 'bootstrap.php';
$sql = "INSERT INTO `allo_goods` ( `goods_url` ) VALUES ";
$pl = [];
$url = "https://allo.ua/benzinovye-generatory/";
$page = $curr_page =1;
$iter = 1;

do
{
  echo '<pre>';
  print_r( $url );
  echo '</pre>';

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
    }
  }

  $curr_page++;
  $url = 'https:' . preg_replace( '#\/p\-(\d+)\/#', '/p-' . $curr_page . '/', $url_page );

  $list = $xpath -> query( '//a[@class="product-name"]' );

  foreach ( $list as $row )
  {
    $sql .= "( :url{$iter} ), ";
    $pl["url{$iter}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
    $iter++;
  }
}
while( $curr_page <= $page );


DB::query( rtrim( $sql, ', ' ), $pl );
echo 'Count products: ' . $iter . '<hr />';