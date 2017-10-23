<?php
//$data = file_get_contents( 'http://bash.im' );

$curlt = curl_init( 'http://test.phpstep.com.ua/blog_bd/add.php' );
curl_setopt( $curlt, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curlt, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
curl_setopt( $curlt, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
$html = curl_exec( $curlt );
curl_close( $curlt );

preg_match( '#name\=\"token\" value\=\"(.*)\"#', $html, $m );
$token = $m[1];

$curl = curl_init( 'http://test.phpstep.com.ua/blog_bd/add.php' );

//curl_setopt( $curl, CURLOPT_URL, 'http://bash.im' );

curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_HEADER, true );

curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
curl_setopt( $curl, CURLOPT_USERAGENT, 'ololo' );
curl_setopt( $curl, CURLOPT_REFERER, "http://bash.im");

curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 5 );
curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );

//curl_setopt( $curl, CURLOPT_PROXY, '103.54.100.18' );
//curl_setopt( $curl, CURLOPT_PROXYPORT, '8080' );

curl_setopt( $curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
curl_setopt( $curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );


curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, [
  'blog_title' => 'test curl 22222222',
  'blog_text'  => 'test curl text 222222222222',
  'token'      => $token,
  'blog_add'   => 'Создать',
] );

$data = curl_exec( $curl );

curl_close( $curl );

var_dump( $data );