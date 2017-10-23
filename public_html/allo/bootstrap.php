<?php
ini_set( 'display_errors', 1 );
ini_set( 'html_errors', 1 );
ini_set( 'log_errors', 1 );
ini_set( 'default_charset', 'utf-8' );
set_time_limit( 60 );
error_reporting(E_ALL);

mb_internal_encoding( 'UTF-8' );

require_once 'functions.php';

class DB
{
  private static $_pdo;

  public static function query( $sql, array $pl = [] )
  {
    self::connect();

    try
    {
      $stm = self::$_pdo -> prepare( $sql );
      $stm -> execute( $pl );

      return $stm;
    }
    catch ( PDOException $e )
    {
      echo '<pre>';
      print_r( $e );
      echo '</pre>';
      exit( 'Ошибка' );
    }
  }

  public static function getPDO(  )
  {
    self::connect();

    return self::$_pdo;
  }

  protected static function connect(  )
  {
    if ( isset( self::$_pdo ) )
      return self::$_pdo;

    try
    {
      self::$_pdo = new PDO(
        'mysql:host=localhost;dbname=test1',
        'test1',
        '12345q',
        [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8', time_zone = '+00:00'",
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
      );
    }
    catch ( PDOException $e )
    {
      exit( 'Подключение не удалось: ' . $e -> getMessage() );
    }

    return self::$_pdo;
  }
}

$sql = "SELECT * FROM `allo_parser` WHERE `parser_status` = 'pause' OR `parser_status` = 'process' LIMIT 1";
$stm = DB::query( $sql );

if ( ! $stm -> rowCount() )
{
  $sql = "INSERT INTO `allo_parser` SET `parser_status` = 'pause'";
  DB::query( $sql );

  $sql = "SELECT * FROM `allo_parser` WHERE `parser_status` = 'pause' OR `parser_status` = 'process' LIMIT 1";
  $stm = DB::query( $sql );
}

$data_parser = $stm -> fetch();
