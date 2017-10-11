<?php
//1
//$data = file_get_contents( 'https://shop.mango.com/services/productlist/products/GB/she/sections_she_MSS.nuevo/?pageNum=1&rowsPerPage=2000&columnsPerRow=2' );
//
//echo '<pre>';
//print_r( count( json_decode( $data, true )['groups'][0]['garments'] ) );
//echo '</pre>';

//2
//$xml    = new SimpleXMLElement( file_get_contents( 'http://polaroideyewear.com/sitemap.xml' ) );
//$a_data = [];
//
//foreach ( $xml -> url as $data )
//{
//  if ( strpos( $data -> loc, 'en/sunglasses/' ) !== false )
//  {
//    if ( substr_count( $data -> loc, '.' ) == 3 )
//      $a_data[ ( string ) $data -> loc ] = 0;
//  }
//}
//
//echo '<pre>';
//print_r($a_data);
//echo '</pre>';

//3
//$url = 'http://polaroideyewear.com/en/sunglasses/pls/2011/07886.black-21749709carc.html';
//
//$product = [];
//
//$page = mb_convert_encoding( file_get_contents( $url ), 'HTML-ENTITIES', "UTF-8" );
//
//$doc  = new \DOMDocument( );
//@$doc -> loadHTML( $page );
//
//$h1        = $doc -> getElementsByTagName( 'h1' );
//$color     = $doc -> getElementById( 'color-frame-code' );
//$colorcode = ( ! trim( @$color -> nodeValue ) ) ? 'xxxxx' . rand( 1, 9999 ) : trim( $color -> nodeValue );
//
//$product[ 2 ] = trim( $h1 -> item( 0 ) -> nodeValue );
//
//$xpath      = new \DOMXPath( $doc );
//
//$desc       = @$xpath -> query( '//p[@itemprop="description"]' );
//
//$product[ 3 ] = trim( $desc -> item( 0 ) -> nodeValue );
//$product[ 4 ] = "Family: " . @$xpath -> query( '//span[@id="family"]' ) -> item( 0 ) -> nodeValue;
//$product[ 5 ] = "Gender: " . @$xpath -> query( '//span[@id="gender"]' ) -> item( 0 ) -> nodeValue;
//$product[ 6 ] = "Material: " . @$xpath -> query( '//span[@id="material"]' ) -> item( 0 ) -> nodeValue;
//
//if ( $cf         = $xpath -> query( '//span[@id="color-frame"]' ) -> item( 0 ) -> nodeValue )
//  $product[ 7 ] = "Color frame: " . $cf . ' - ' . $xpath -> query( '//span[@id="color-frame-code"]' ) -> item( 0 ) -> nodeValue;
//else
//  $product[ 7 ] = '';
//
//$product[ 8 ] = "Color lens: " . $xpath -> query( '//span[@id="color-lens"]' ) -> item( 0 ) -> nodeValue . ' - ' . $xpath -> query( '//span[@id="color-lens-code"]' ) -> item( 0 ) -> nodeValue;
//
//$image = $xpath -> query( '//img[@id="main-img"]/@src' );
//
//$product[ 9 ]  = $image -> item( 0 ) -> nodeValue;
//$product[ 10 ] = $url;
//
//
//echo '<pre>';
//print_r($product);
//echo '</pre>';

//4
//$doc  = new \DOMDocument( );
//@$doc -> loadHTML( mb_convert_encoding( file_get_contents( 'https://allo.ua/' ), 'HTML-ENTITIES', "UTF-8" ) );
//
//$xpath      = new \DOMXPath( $doc );
//$l1       = @$xpath -> query( '//a[@class="level1 smartfonu_i_telefonu"]' );
//
//foreach ( $l1 as $row )
//{
//  echo '<pre>';
//  print_r( $row -> nodeValue );
//  echo '</pre>';
//  echo '<pre>';
//  print_r( $row -> getAttribute( 'href' ) );
//  echo '</pre><hr />';
//}

//5
//https://allo.ua/ru/products/mobile/klass-kommunikator_smartfon/p-1/
//https://allo.ua/ru/products/mobile/klass-kommunikator_smartfon/p-2/
//https://allo.ua/ru/products/mobile/klass-kommunikator_smartfon/p-3/

for( $i = 1; $i <= 1; $i++ )
{
  $doc  = new \DOMDocument( );
  @$doc -> loadHTML( mb_convert_encoding( file_get_contents( 'https://allo.ua/ru/products/mobile/klass-kommunikator_smartfon/p-'.$i.'/' ), 'HTML-ENTITIES', "UTF-8" ) );

  $xpath      = new \DOMXPath( $doc );
  $l1       = @$xpath -> query( '//a[@class="product-name"]' );

  foreach ( $l1 as $row )
  {
    echo '<pre>';
    print_r( trim( $row -> nodeValue ) );
    echo '</pre>';
    echo '<pre>';
    print_r( $row -> getAttribute( 'href' ) );
    echo '</pre><hr />';
  }
}


  $page  = @$xpath -> query( '//ol/li/a[@class="last"]' );
  echo '<pre>';
  print_r( $page -> item( 0 ) -> nodeValue );
  echo '</pre>';