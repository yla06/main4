<?php
//authorize
//$curl = curl_init( 'http://test.phpstep.com.ua/blog_bd/authorize.php' );
//
//curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $curl, CURLOPT_HEADER, true );
//
//curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
//curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
//
//curl_setopt( $curl, CURLOPT_USERAGENT, 'ololo' );
//curl_setopt( $curl, CURLOPT_COOKIEJAR,  $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//curl_setopt( $curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//
//$a_login = [
//  //['login', 'pass'],
//  //['login2', 'pass'],
//  ['admin', 'admin'],
//  ['login4', 'pass'],
//];
//
//curl_setopt( $curl, CURLOPT_POST, true );
//curl_setopt( $curl, CURLOPT_POSTFIELDS, $a = [
//  'login'            => $a_login[0][0],
//  'password'         => $a_login[0][1],
//  'submit_authorize' => 'Авторизация',
//] );
//
//echo '<pre>';
//print_r( $a );
//echo '</pre>';
//$data = curl_exec( $curl );
//
//curl_close( $curl );
//
//if ( preg_match( '#value\=\"Авторизация\"#', $data ) )
//  echo 'Нет авторизации';
//else
//  echo 'Авторизация есть';
//var_dump( $data );
//exit( 'Stoped: <b>' . mf_get_spath() . '</b>' );


//add
//$curlt = curl_init( 'http://test.phpstep.com.ua/blog_bd/add.php' );
//curl_setopt( $curlt, CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $curlt, CURLOPT_USERAGENT, 'ololo' );
//curl_setopt( $curlt, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//curl_setopt( $curlt, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//$html = curl_exec( $curlt );
//curl_close( $curlt );
//
//preg_match( '#name\=\"token\" value\=\"(.*)\"#', $html, $m );
//$token = $m[1];
//
//$curl = curl_init( 'http://test.phpstep.com.ua/blog_bd/add.php' );
//
////curl_setopt( $curl, CURLOPT_URL, 'http://bash.im' );
//
//curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
//curl_setopt( $curl, CURLOPT_HEADER, true );
//
//curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
//curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
//curl_setopt( $curl, CURLOPT_USERAGENT, 'ololo' );
//curl_setopt( $curl, CURLOPT_REFERER, "http://bash.im");
//
//curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 5 );
//curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
//
////curl_setopt( $curl, CURLOPT_PROXY, '103.54.100.18' );
////curl_setopt( $curl, CURLOPT_PROXYPORT, '8080' );
//
//curl_setopt( $curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//curl_setopt( $curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/curl/test-cookie.txt' );
//
//
//curl_setopt( $curl, CURLOPT_POST, true );
//curl_setopt( $curl, CURLOPT_POSTFIELDS, [
//  'blog_title' => 'test curl 7777777777',
//  'blog_text'  => 'test curl text 777777777777',
//  'token'      => $token,
//  'blog_add'   => 'Создать',
//] );
//
//$data = curl_exec( $curl );
//
//curl_close( $curl );
//
//var_dump( $data );