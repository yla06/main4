<?php
//$curl = curl_init( 'http://www.mak.lutsk.ua/MoveOnMap?_=1508949817708&level=1&nodeid=1' );
//curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
////curl_setopt( $curl, CURLOPT_HEADER, true );
//
//curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
//curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
//
//curl_setopt( $curl, CURLOPT_HTTPHEADER, [
//  'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linu…) Gecko/20100101 Firefox/56.0',
//  'Referer: http://www.mak.lutsk.ua/guest',
//  'Cookie: PHPSESSID=c5391g2halof71akjjgmfhnqt3',
//] );
//
//$out = curl_exec( $curl );
//curl_close( $curl );
//
//echo '<pre>';
//print_r( json_decode( $out, true ) );
//echo '</pre>';



$curl = curl_init( 'https://www.vtb24.ru/services/ExecuteAction' );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, '{"action":"{\"action\":\"OfficeBusyService\"}","scopeData":"{\"method\":\"GetOffices\",\"query\":{\"Bounds\":{\"LeftBottomLatitide\":-90,\"LeftBottomLongitude\":-180,\"RightTopLatitide\":90,\"RightTopLongitude\":180},\"WorkOnWeekends\":false,\"Services\":[],\"OfficeId\":null}}"}' );
curl_setopt( $curl, CURLOPT_HTTPHEADER, array (
  'Content-Type:application/json',
  'X-Requested-With:XMLHttpRequest',
  'Referer:https://www.vtb24.ru/map',
  'Cookie:geoAttr=moscow; ASPSESSIONIDSCDQABDT=IGNHFECDFLFIINEGBAFFCCHD; ASPSESSIONIDSCBTCCBT=OPJNMDCDKCMPBEOGGMLBFGOD'
) );

$out = curl_exec( $curl );
curl_close( $curl );

foreach ( json_decode( $out, true )['getOfficesResult'] as $i => $row )
{
  $prop = json_decode( $row['properties'], true );

  $pl[ "id{$i}" ]                            = $row[ 'id' ];
  $pl[ "latitude{$i}" ]                      = $row[ 'latitude' ];
  $pl[ "longitude{$i}" ]                     = $row[ 'longitude' ];
  $pl[ "privilegeServicesOnly{$i}" ]         = $row[ 'privilegeServicesOnly' ];
  $pl[ "Office_CashDeskOperationTime{$i}" ]  = $prop[ 'Office_CashDeskOperationTime' ];
  $pl[ "Office_HasRamp{$i}" ]                = $prop[ 'Office_HasRamp' ];
  $pl[ "BisId{$i}" ]                         = $prop[ 'BisId' ];
  $pl[ "Privilege_services_only{$i}" ]       = $prop[ 'Privilege_services_only' ];
  $pl[ "Office_JuristicPersonSchedule{$i}" ] = $prop[ 'Office_JuristicPersonSchedule' ];
  $pl[ "Office_NaturalPersonSchedule{$i}" ]  = $prop[ 'Office_NaturalPersonSchedule' ];
  $pl[ "Office_Rating{$i}" ]                 = $prop[ 'Office_Rating' ];
  $pl[ "Office_ShortName{$i}" ]              = $prop[ 'Office_ShortName' ];
  $pl[ "Office_WorkOnWeekends{$i}" ]         = $prop[ 'Office_WorkOnWeekends' ];
  $pl[ "ServicePoint_Address{$i}" ]          = $prop[ 'ServicePoint_Address' ];
  $pl[ "GeoObjects_GeoObject{$i}" ]          = $prop[ 'GeoObjects_GeoObject' ];
  $pl[ "Office_NearestSubwayName{$i}" ]      = $prop[ 'Office_NearestSubwayName' ];
  $pl[ "Office_NearestSubwayDistance{$i}" ]  = $prop[ 'Office_NearestSubwayDistance' ];
  $pl[ "Title{$i}" ]                         = $prop[ 'Title' ];
  $pl[ "JuristicPersonService{$i}" ]         = $prop[ 'JuristicPersonService' ];
}

echo '<pre>';
print_r($pl);
echo '</pre>';