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
      self::log( $e -> getMessage() );

      exit( 'Ошибка' );
    }
  }

  public static function log( $desc )
  {
    $pdo = new PDO( 'sqlite:'. $_SERVER['DOCUMENT_ROOT'] . '/test_log.sqlite' );

    $sql = "INSERT INTO `error_log`
              ( `error_type`, `error_desc`,
              `error_date`, `error_server`, `error_request` )
              VALUES ( :type, :desc, :date, :server, :request )";

    $input_param = array(
      'type' => 'SQL',
      'desc' => $desc,
      'date' => time(  ),
      'server'  => serialize( $_SERVER ),
      'request' => serialize( $_REQUEST ),
    );

    $prep = $pdo -> prepare( $sql );
    $a = $prep -> execute( $input_param );

    echo '<pre>';
    print_r( $a );
    echo '</pre>';
    exit( 'Stoped: <b>' . mf_get_spath() . '</b>' );

    return true;
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

class  Foo
{
  public function test(  )
  {
    $result = DB::query( "ERR SELECT * FROM `blog`" );

    echo '<pre>';
    print_r( $result -> fetchAll() );
    echo '</pre>';

    $result = DB::query( "UPDATE `blog` SET `title` = '". time()."' WHERE `id` = 13" );

    echo '<pre>';
    print_r( $result -> rowCount(  ) );
    echo '</pre>';

    $result = DB::query( "SELECT * FROM `blog` WHERE `id` = ? ", [13] );

    echo '<pre>';
    print_r( $result -> fetch() );
    echo '</pre>';
  }
}

$o = new Foo;
$o -> test(  );
