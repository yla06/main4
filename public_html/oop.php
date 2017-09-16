<?php
//class Foo
//{
//  public $a = 1;
//  public $b = 2;
//  public $c = 3;
//
////  public function setA( $data )
////  {
////    $this -> a = $data;
////  }
////
////  public function getA(  )
////  {
////    return $this -> a;
////  }
////
////  public function __call( $name, $arguments )
////  {
////    $arr = [ 'a', 'b', 'c' ];
////    $name_var = mb_strtolower( substr( $name, 3 ) );
////
////    if ( 0 === strpos( $name, 'get' ) )
////    {
////      if ( in_array( $name_var, $arr ) )
////        return $this -> $name_var;
////    }
////
////    if ( 0 === strpos( $name, 'set' ) )
////    {
////      if ( in_array( $name_var, $arr ) )
////        $this -> $name_var = ( isset( $arguments[0] ) ? $arguments[0] : null );
////    }
////  }
////
////  public static function __callStatic( $name, $arguments )
////  {
////    echo '<pre>';
////    print_r( $name );
////    echo '</pre>';
////
////    echo '<pre>';
////    print_r( $arguments );
////    echo '</pre>';
////  }
////
////  public function __set( $name, $value )
////  {
////    $arr = [ 'c', 'd' ];
////
////    if ( in_array( $name, $arr ) )
////      $this -> $name = $value;
////  }
////
////  public function __get( $name )
////  {
////    return 20;
////  }
////
////  public function __isset( $name )
////  {
////    echo 'isset';
////    echo '<pre>';
////    print_r( $name );
////    echo '</pre>';
////
////  }
////
////  public function __unset( $name )
////  {
////    echo 'unset';
////    echo '<pre>';
////    print_r( $name );
////    echo '</pre>';
////  }
//  public function __sleep()
//  {
//    return ['a','b', 'c'];
//  }
//
//  public function __debugInfo()
//  {
//    return [
//      'a' => 777,
//      'b' => 888,
//    ];
//  }
//}
//
//$o = new Foo;
//
//echo '<pre>';
//var_dump( $o );
//echo '</pre>';
//exit( 'Stoped: <b>' . mf_get_spath() . '</b>' );
//
////echo '<pre>';
////print_r( $o -> a );
////echo '</pre>';
////isset( $o -> a ) ;
////unset( $o -> c ) ;
////echo '<pre>';
////print_r( $o );
////echo '</pre>';
//
//exit;
#################1
//class Foo
//{
//  public $foo    = 1;
//  protected $bar = 2;
//  private $baz   = 3;
//
//  public function getFoo()
//  {
//    echo $this -> foo;
//  }
//
//  public function getBar()
//  {
////    if ( проверка администратора )
//      return $this -> bar;
////    else
////      return null;
//  }
//
//  public function setBar( $data )
//  {
//    //0 - 100
//    if ( is_numeric( $data ) and $data >= 0 and $data <= 100 )
//      return $this -> bar = $data;
//    else
//      return null;
//  }
//
//  public function buy()
//  {
//    echo 'buy';
//    $this -> delivery();
//  }
//
//  protected function delivery()
//  {
//    echo 'delivery';
//  }
//}
//
//$o = new Foo;
//$o -> setBar( 101 );
//echo $o -> getBar();
//
//$o -> buy();
//
//echo '<pre>';
//print_r( $o );
//echo '</pre>';




#################2
//class A
//{
//  public $a    = 1;
//  protected $b = 2;
//  private $c   = 3;
//
//  public final function printA()
//  {
//    echo $this -> a;
//  }
//
//  protected function printB()
//  {
//    echo $this -> b;
//  }
//
//  public function printC()
//  {
//    echo $this -> c;
//  }
//
//  public function printABC()
//  {
//    $this -> printA();//1
//    $this -> printB();//2
//    $this -> printC();//3
//  }
//}
//
//class B extends A
//{
//  private $c   = 333;
//
//  public function printC()
//  {
//    echo $this -> c;
//  }
//}
//
//$obj = new A;
//$obj -> printC();
//
//
//$obj2 = new B;
//$obj2 -> printC();





#################3
//abstract class Animal
//{
//  protected $_voice;
//  protected $_move;
//  protected $_tail;
//
//  public function voice(  )
//  {
//    echo 'Говорит: ' . $this -> _voice . '<br />';
//  }
//
//  public function move(  )
//  {
//    echo 'Я двигаюсь: ' . $this -> _move . '<br />';
//  }
//
//  public function tail(  )
//  {
//    echo 'У меня: ' . ( ( $this -> _tail ) ? 'есть хвост' : 'нет хвоста' ) . '<br />';
//  }
//
//  public abstract function maxSpeed();
//}
//
//class Dog extends Animal
//{
//  protected $_voice = 'гав';
//  protected $_move = 'на 4 лапах';
//  protected $_tail = true;
//
//  public function maxSpeed()
//  {
//    echo 'Я бегаю макс 30 км';
//  }
//}
//
//class Cat extends Animal
//{
//  protected $_voice = 'мяу';
//  protected $_move = 'на 4 лапах';
//  protected $_tail = true;
//
//  public function maxSpeed()
//  {
//    echo 'Я бегаю макс 10 км';
//  }
//}
//
//class Duck extends Animal
//{
//  protected $_voice = 'кря';
//  protected $_move = 'на 2 лапах';
//  protected $_tail = false;
//
//  public function maxSpeed()
//  {
//    echo 'Я бегаю макс 5 км. Летаю если есть крылья и плаваю';
//  }
//}
//
//$dog  = new Dog;
//$cat  = new Cat;
//$duck = new Duck;
//
//echo 'Dog:<br />';
//$dog -> voice();
//$dog -> tail();
//$dog -> move();
//$dog -> maxSpeed();
//
//echo '<hr />Cat:<br />';
//$cat -> voice();
//$cat -> tail();
//$cat -> move();
//$cat -> maxSpeed();
//
//echo '<hr />Duck:<br />';
//$duck -> voice();
//$duck -> tail();
//$duck -> move();
//$duck -> maxSpeed();

//class Foo
//{
//  public function __construct( $data )
//  {
//    echo $data + 10;
//  }
//
//  public function __destruct(  )
//  {
//    echo 5;
//  }
//}
//
//$o = new Foo( 10 );
//echo 6;
//echo 7;

















//class Foo
//{
//  protected $bar        = 1;
//  protected static $baz = 2;
//
//  public function setBar( $data )
//  {
//    $this -> bar = $data;
//  }
//
//  public function getBar()
//  {
//    return $this -> bar +  Foo::$baz ;
//  }
//
//  public static function setBaz( $data )
//  {
//    Foo::$baz = $data;
//  }
//
//  public static function getBaz()
//  {
//    return Foo::$baz ;
//  }
//}
//
//
//Foo::setBaz( 9 );
//echo Foo::getBaz();
//
//
//$o1 = new Foo;
//
//echo '<pre>';
//print_r( $o1 -> getBar() );
//print_r( $o1 -> getBaz() );
//echo '</pre>';
//
//$o2 = new Foo;
//
//echo '<pre>';
//print_r( $o2 -> getBar() );
//print_r( $o2 -> getBaz() );
//echo '</pre>';




























//interface FooInterface
//{
//  const TEST = 1;
//
//  public function getFoo(  );
//  public function setFoo( $data );
//  public function change(  );
//}
//
//abstract class FooAbstract implements FooInterface
//{
//  protected $_data;
//
//  public function getFoo(  )
//  {
//    return $this -> _data;
//  }
//
//  public function setFoo( $data )
//  {
//    $this -> _data = $data;
//  }
//}
//
//class Plus extends FooAbstract
//{
//  public function change(  )
//  {
//    $this -> _data += 50;
//  }
//}
//
//class Minus extends FooAbstract
//{
//  public function change(  )
//  {
//    $this -> _data -= 47;
//  }
//}
//
//$o = new Plus();
//$o -> setFoo( 41 );
//$o -> change();
//echo $o -> getFoo(  );

trait TraitFoo
{
  protected $foo = 1;

  public function setFoo( $data )
  {
    $this -> foo = $data;
  }

  public function getFoo()
  {
    return $this -> foo;
  }
}

class A
{
  use TraitFoo;

  public function calc( $numer )
  {
    echo $this -> foo + $numer;
  }
}

class B
{
  use TraitFoo;
  
  public function tree(  )
  {
    echo $this -> foo + 15;
  }
}

$a = new A;
$a -> calc( 10 );

$b = new B;
$b -> tree(  );