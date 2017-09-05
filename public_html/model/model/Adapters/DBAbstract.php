<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/model/model/ModelAbstract.php";

abstract class DBAbstract extends ModelAbstract
{
  protected static $_connect;
  public static $host, $user, $pass, $db;

  public function __construct(  )
  {
    parent::__construct();
    self::connectDB();
  }

  public function insert(  )
  {
    $target = self::getProperty( '_target' );

    $sql = "INSERT INTO `{$target}` SET ";

    foreach ( $this -> _fields as $name )
      $sql .= "`{$this -> _rules[$name][0]}` = '" . mysql_real_escape_string( $this -> $name, self::$_connect ) . "', ";

    return self::exec( rtrim( $sql, ', ' ) );
  }

  public function update(  )
  {
    $target = self::getProperty( '_target' );

    $sql = "UPDATE `{$target}` SET ";

    foreach ( $this -> _fields as $name )
    {
      if ( $name == 'id' )
        continue;

      $sql .= "`{$this -> _rules[$name][0]}` = '" . mysql_real_escape_string( $this -> $name, self::$_connect ) . "', ";
    }

    $sql = rtrim( $sql, ', ' ) . " WHERE `{$this -> _rules['id'][0]}` = '" . intval( $this -> id ) . "' LIMIT 1";

    return self::exec( rtrim( $sql, ', ' ) );
  }

  public function delete( $id )
  {
    $target = self::getProperty( '_target' );

    $sql = "DELETE  FROM `{$target}` WHERE `{$this -> _rules['id'][0]}` = '" . intval( $id ) . "' LIMIT 1";

    return self::exec( rtrim( $sql, ', ' ) );
  }

  public static function selectAll(  )
  {
    $target = self::getProperty( '_target' );

    $sql = "SELECT * FROM `{$target}` ";

    $result = self::query( rtrim( $sql, ', ' ) );

    $return = [];

    while ( $row = mysql_fetch_assoc( $result ) )
    {
      $class = get_called_class();
      $model = new $class;

      $model -> fill( $row );
      $return[$row[self::getProperty( '_rules' )['id'][0]]] = $model;
    }

    return $return;
  }

  public static function selectById( $id )
  {
    $target = self::getProperty( '_target' );

    $sql = "SELECT * FROM `{$target}` WHERE `" . self::getProperty( '_rules' )['id'][0] . "` = '" . intval( $id ) . "' LIMIT 1";

    $result = self::query( rtrim( $sql, ', ' ) );
    $data = mysql_fetch_assoc( $result );

    $class = get_called_class();
    $model = new $class;
    $model -> fill( $data );

    return $model;
  }

  protected static function connectDB(  )
  {
    if ( isset( self::$_connect ) )
      return self::$_connect;

    self::$_connect = @mysql_connect( self::$host, self::$user, self::$pass );

    if ( ! self::$_connect )
      die( 'Ошибка соединения: ' . mysql_error(  ) );

    $db_selected = mysql_select_db( self::$db, self::$_connect );

    if ( ! $db_selected )
      die( 'Не удалось выбрать базу: ' . mysql_error(  ) );

    mysql_query( "SET collation_connection = utf8_general_ci", self::$_connect );
    mysql_query( "SET NAMES utf8", self::$_connect );
  }

  protected static function exec( $sql )
  {
    if ( mysql_query( $sql, self::$_connect ) )
      return mysql_affected_rows(  );
    else
      exit( mysql_error( self::$_connect ) );//return false;
  }

  protected static function query( $sql )
  {
    if ( $result = mysql_query( $sql ) )
      return $result;
    else
      exit( mysql_error( self::$_connect ) );//return false;
  }

}