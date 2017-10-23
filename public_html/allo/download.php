<?php
require_once 'bootstrap.php';

$id = ( isset( $_GET['id'] ) and is_string( $_GET['id'] ) and ctype_digit( $_GET['id'] ) ) ? $_GET['id'] : 0;

$sql  = "SELECT * FROM `allo_parser` WHERE `parser_id` = '{$id}'";
$data = $stm  = DB::query( $sql ) -> fetch();

$sql = "SELECT * FROM `allo_goods` WHERE `goods_parser_id` = '{$id}' AND `goods_status` = 1";
$all_data = $stm  = DB::query( $sql ) -> fetchAll();

//xls

require_once('PHPExcel/PHPExcel.php');

$doc = new PHPExcel();
$doc -> setActiveSheetIndex( 0 );
$doc -> getActiveSheet() -> fromArray( $all_data );

header( 'Content-Type: application/vnd.ms-excel' );
header( 'Content-Disposition: attachment;filename="just_some_random_name.xls"' );
header( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter( $doc, 'Excel5' );
$objWriter -> save( 'php://output' );



//csv
//header( "Content-type: text/csv" );
//header( "Content-Disposition: attachment; filename=hkjdfskhjfsdkhjdfshkj.csv" );
//header( "Pragma: no-cache" );
//header( "Expires: 0" );
//
//echo array2csv( $all_data );
//exit;