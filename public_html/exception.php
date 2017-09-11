<?php
//1
//function foo1( $data )
//{
//  $data ++;//15
//
//  return foo2( $data );
//}
//
//function foo2( $data )
//{
//  $data -=15 ;//0
//
//  $data = foo3( $data );
//
//
//  if ( is_string( $data ) )
//    return $data;
//  else
//    $data += 5;
//
//  return $data;
//
//}
//
//function foo3( $data )
//{
//  if ( $data != 0 )
//    return 100 / $data;
//
//  else
//    return 'На ноль делить нельзя';
//}
//
//$data = 14;
//$res = foo1( $data );
//
//if ( is_string( $res ) )
//  echo 'Ошибка: ' . $res;
//else
//  echo $res + 50;


// 2
//class DevelException extends Exception
//{
//  public function __construct( $message = "", $code = 0, $previous = null )
//  {
//    parent::__construct( $message, $code, $previous );
//    //log
//  }
//}
//
//class CoreException extends Exception {
//  public function __construct( $message = "", $code = 0, $previous = null )
//  {
//    parent::__construct( $message, $code, $previous );
//    //log
//    //sms email
//  }
//}
//
//function foo1( $data )
//{
//  $data ++;//15
//  return foo2( $data );
//}
//
//function foo2( $data )
//{
//  $data -=15 ;//0
//  $data = foo3( $data );
//  $data += 5;
//  return $data;
//}
//
//function foo3( $data )
//{
//  throw new DevelException( 'На ноль делить нельзя' );
//
//  if ( $data != 0 )
//    return 100 / $data;
//
//  else
//    throw new Exception( 'На ноль делить нельзя' );
//}
//
//try
//{
//  $data = 14;
//  echo foo1( $data ) + 50;
//}
//catch ( DevelException $e )
//{
//  echo $e -> getMessage();
//}
//catch ( CoreException $e )
//{
//  echo $e -> getMessage();
//  exit;
//}
//catch ( Exception $e )
//{
//  echo 44;exit;
//}
//
//echo 99;


//3
//try
//{
//  echo 1;
//
//  try
//  {
//    throw new Exception('error');
//  }
//  catch ( Exception $exc )
//  {
//    echo 5;
//    throw new Exception('error2');
//  }
//  finally
//  {
//    echo 2;
//  }
//}
//catch ( Exception $exc )
//{
//  echo 3;
//}
//
//echo 4;


define( 'LOG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/shop/upload' );

log2( 'ERROR', 'Тестовое уведомление', __LINE__, __FILE__, true );

// log
function log2( $code_type, $desc, $line = 0, $file = '', $mail = FALSE )
{
  /**
   * Метод записи кодов(ошибок)
   *
   * Вид: log( тип кода(ошибки), описание, линия в файле, файл, отправка уведомления );
   * Пример: log( 'ERROR', 'Тестовое уведомление', __LINE__, __FILE__, true );
   *
   * @param string  $code_type  тип ошибки
   * @param string  $desc       описание ошибки
   * @param integer $line       линия где возникла ошибка
   * @param string  $file       файл где возникла ошибка
   * @param bool    $mail       неоходимость уведомления
   * @return true
   */

  //Определение типа ошибки
  switch ( $code_type )
  {
    case 'WARNING' : $type = 'warning';
      break;  //Попытка взлома
    case 'FATAL_ERROR' : $type = 'fatal';
      break;  //Фатальная ошибка
    case 'SQL_ERROR' : $type = 'sql';
      break;  //Ошибки sql запросов
    case 'ERROR' : $type = 'error';
      break;  //Обычные ошибки
    case 'SYSTEM' : $type = 'system';
      break;  //Системные ошибки
    default : $type = 'unn';             //Неизвестные.
  }

  if ( ! file_exists( LOG_PATH ) )
    mkdir( LOG_PATH, 0777 );
  else if ( substr( sprintf( '%o', fileperms( LOG_PATH ) ), -4 ) != '0777' )
    chmod( LOG_PATH, 0777 );

  if ( ! file_exists( LOG_PATH . '/' . $type ) )
    mkdir( LOG_PATH . '/' . $type, 0777 );
  else if ( substr( sprintf( '%o', fileperms( LOG_PATH . '/' . $type ) ), -4 ) != '0777' )
    chmod( LOG_PATH . '/' . $type, 0777 );

  if ( ! file_exists( LOG_PATH . '/list.txt' ) )
  {
    $fo = fopen( LOG_PATH . '/list.txt', 'w+' );
    chmod( LOG_PATH . '/list.txt', 0777 );
  }

//  else if ( in_array( "{$type} | " . htmlspecialchars( $desc ) . " | {$file} | {$line}\n", file( LOG_PATH . '/list.txt' ) ) )
//    return '';

  else
    $fo = fopen( LOG_PATH . '/list.txt', 'a+' );


  fputs( $fo, $type . " | " . htmlspecialchars( $desc ) . " | " . $file . " | " . $line . "\n" );
  fclose( $fo );

  $rand = rand( 1, 999 );
  $fp   = fopen( LOG_PATH . '/' . $type . '/' . time() . '_' . $rand . '.txt', 'w' );
  chmod( LOG_PATH . '/' . $type . '/' . time() . '_' . $rand . '.txt', 0777 );

  $s_server  = '';
  $s_request = '';
  $s_env     = '';

  foreach ( $_SERVER as $key => $value )
    $s_server .= "'{$key}' = '{$value}'\n";

  foreach ( $_REQUEST as $key => $value )
    $s_request .= "'{$key}' = '{$value}'\n";

  foreach ( $_ENV as $key => $value )
    $s_env .= "'{$key}' = '{$value}'\n";

  fputs( $fp, "Дата: " . date( 'd/m/Y H:i:s' ) . "\n" );
  fputs( $fp, "IP: " . $_SERVER[ 'REMOTE_ADDR' ] . "\n" );
  fputs( $fp, "Host: " . gethostbyaddr( $_SERVER[ 'REMOTE_ADDR' ] ) . "\n" );
  fputs( $fp, "ENV:\n" . htmlspecialchars( trim( $s_env ) ) . "\n\n" );
  fputs( $fp, "SERVER:\n" . htmlspecialchars( trim( $s_server ) ) . "\n\n" );
  fputs( $fp, "REQUEST:\n" . htmlspecialchars( trim( $s_request ) ) . "\n" );
  fputs( $fp, "Класификация ошибки:\n" );
  fputs( $fp, $desc . "; (Файл:{$file} / Линия:{$line})\n" );
  fclose( $fp );

  return true;
}
