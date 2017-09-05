<?php
require_once 'ModelInterface.php';

abstract class ModelAbstract implements ModelInterface
{
  protected $_target;
  protected $_rules;
  protected $_fields = [];
  protected $_reverseFields;

  public function __construct(  )
  {
    if ( ! isset( $this -> _reverseFields ) )
    {
      foreach ( $this -> _rules as $alias => $rule )
        $this -> _reverseFields[$rule[0]] = $alias;
    }
  }

  public function __set( $name, $value )
  {
    if ( isset( $this -> _rules[$name]) )
    {
      $this -> $name = $value;
      $this -> _fields[] = $name;
    }
    else
      exit( "Свойство \"{$name}\" не может быть создано так как оно отсутствует в описании модели." );
  }

  public function __get( $name )
  {
    return $this -> $name;
  }

  public function save(  )
  {
    if ( false !== array_search( 'id', $this -> _fields ) )
      return $this -> update (  );
    else
      return $this -> insert(  );
  }

  protected static function getProperty( $name )
  {
    $class_name = get_called_class();
    $tmp = new $class_name;

    $class = new ReflectionClass( $tmp );
    $property = $class -> getProperty( $name );
    $property -> setAccessible( true );

    return $property -> getValue( $tmp );
  }

  public function fill( $a_data )
  {
    foreach ( $a_data as $name => $data )
      $this -> {$this -> _reverseFields[$name]} = $data;

    return $this;
  }

  public function fetch(  )
  {
    $return = [];

    foreach ( $this -> _fields as $name )
      $return[ $this -> _rules[$name][0]] = $this -> $name;

    return $return;
  }
}