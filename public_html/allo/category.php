<?php
require_once 'bootstrap.php';
exit;
//$doc = new \DOMDocument( );
//@$doc -> loadHTML( mb_convert_encoding( $a = file_get_contents( 'https://allo.ua/' ), 'HTML-ENTITIES', "UTF-8" ) );
//$xpath = new \DOMXPath( $doc );
//
////// 1 level category
//$list = $xpath -> query( '//li[contains(@class, "level-top")]/div/a' );
//
//$sql = "INSERT INTO `allo_category` ( `category_real_path`, `category_real_name`, `category_real_level` ) VALUES ";
//$pl = [];
//
//foreach ( $list as $i => $row )
//{
//  $sql .= "( :id{$i}, :name{$i}, 1 ), ";
//  $pl["id{$i}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
//  $pl["name{$i}"] = trim( $row -> nodeValue );
//}
//
//DB::query( rtrim( $sql, ', ' ), $pl );
//echo 'Level 1: ' . $i . '<hr />';
//
////// 2 level category
//$list = $xpath -> query( '//a[contains(@class, "level1")]' );
//
//$sql = "INSERT INTO `allo_category` ( `category_real_path`, `category_real_name`, `category_real_level` ) VALUES ";
//$pl = [];
//
//foreach ( $list as $i => $row )
//{
//  $sql .= "( :id{$i}, :name{$i}, 2 ), ";
//  $pl["id{$i}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
//  $pl["name{$i}"] = trim( $row -> nodeValue );
//}
//
//DB::query( rtrim( $sql, ', ' ), $pl );
//echo 'Level 2: ' . $i . '<hr />';
//
//// 3 level category
//$list = $xpath -> query( '//a[contains(@class, "level2")]' );
//
//$sql = "INSERT INTO `allo_category` ( `category_real_path`, `category_real_name`, `category_real_level` ) VALUES ";
//$pl = [];
//
//foreach ( $list as $i => $row )
//{
//  $name = trim( $row -> nodeValue );
//
//  if ( 0 === strpos( $name, 'Все' ) )
//    continue;
//
//  $sql .= "( :id{$i}, :name{$i}, 3 ), ";
//  $pl["id{$i}"] = str_replace( '//allo.ua/', '', $row -> getAttribute( 'href' ) );
//  $pl["name{$i}"] = $name;
//}
//
//DB::query( rtrim( $sql, ', ' ), $pl );
//echo 'Level 3: ' . $i . '<hr />';