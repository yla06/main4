<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/model/model/ModelAbstract.php";

abstract class FileAdapter extends ModelAbstract
{
  protected static $_data ;

  protected static function getAllData()
  {
    if ( ! isset( FileAdapter::$_data ) )
      self::$_data = self::selectAllData();

    return FileAdapter::$_data;
  }

  protected function saveData(  )
  {
    return file_put_contents( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$this -> _target}.dat", serialize( FileAdapter::$_data ) );
  }

  public function insert(  )
  {
    foreach ( $this -> _rules as $name => $rule )
    {
      if ( 'id' === $name )
        continue;

      if ( isset( $this -> $name ) )
        $data[$rule[0]] = $this -> $name;
      else
        $data[$rule[0]] = '';
    }

    self::getAllData(  );
    self::$_data[] = $data;
    $this -> saveData();
  }

  protected static function selectAllData(  )
  {
    $target = self::getProperty( '_target' );

    if ( file_exists( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat" ) )
      return unserialize( file_get_contents( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat" ) );

    file_put_contents( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat", 'a:0:{}' );
    return [];
  }

  public static function selectAll(  )
  {
    $target = self::getProperty( '_target' );

    if ( file_exists( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat" ) )
    {
      $all_data = unserialize( file_get_contents( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat" ) );
      $return = [];

      foreach ( $all_data as $id => $data )
      {
        $class = get_called_class();
        $model = new $class;

        $data[ self::getProperty( '_rules' )['id'][0] ] = $id;
        $model -> fill( $data );
        $return[$id] = $model;
      }

      return $return;
    }


    file_put_contents( "{$_SERVER['DOCUMENT_ROOT']}/model/file_storage/{$target}.dat", 'a:0:{}' );
    return [];
  }

  public function update(  )
  {
    foreach ( $this -> _fields as $name )
    {
      if ( 'id' === $name )
        continue;

      $data[ $this -> _rules[$name][0]] = $this -> $name;
    }

    self::getAllData(  );
    self::$_data[$this -> id] = $data;
    $this -> saveData();
  }

  public function delete( $id )
  {
    self::getAllData(  );
    unset( self::$_data[$id] );

    $this -> saveData();
  }

  public static function selectById( $id )
  {
    $row = self::getAllData(  )[$id];
    $row[ self::getProperty( '_rules' )['id'][0] ] = $id;

    $class = get_called_class();
    $model = new $class;
    $model -> fill( $row );

    return $model;
  }
}
