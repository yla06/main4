<?php
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
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
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