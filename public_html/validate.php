<?php
/**
 * Абстрактный класс для создания множества однотипных классов валидаторов с
 * одинаковым функционалом.
 */
abstract class ValidateAbstract
{
  /**
   * Системные константы которые указывают на тип валидатора.
   *
   * TYPE_STRING используется по умолчанию для всех дочерних классов валидаторов
   * и определяет, что вадидатор работает со строками
   *
   * TYPE_ARRAY используется для валидаторов которые работают с массивами
   *
   * TYPE_FILE используется для валидаторов загружаемых файлов
   *
   * при необходимости создать валидатор для массива или файла, необходимо в нем
   * перегрузить свойство класса:
   * protected $_type = ValidateAbstract::TYPE_FILE; //Для файла
   * protected $_type = ValidateAbstract::TYPE_ARRAY; // Для массива
   */
  const TYPE_STRING = 1;
  const TYPE_ARRAY  = 2;
  const TYPE_FILE   = 3;

  /**
   * @var int свойство указывающее на тип валидатора с которым он работает.
   */
  protected $_type = ValidateAbstract::TYPE_STRING;

  /**
   * @var array свойство стандартных для всех атрибутов валидаторов
   */
  protected $_attr = [
    'required' => true,
  ];

  /**
   * Указываем, что при создании дочерних классов в них необходимо переопределить
   * метод проверки данных поскольку он должен быть индивидуальных для каждого
   * валидатора
   */
  public abstract function check( $data );

  /**
   * @return int Геттер свойства _type
   */
  public function getType(  )
  {
    return $this -> _type;
  }

  /**
   * Метод для установки и переопределения стандартных атрибутов валидатора
   * Должен передаться как массив
   *
   * @param array $attr устанавливаемые атрибуты валидатора
   * @return boolean|$this
   */
  public function setAttribute( array $attr )
  {
    $this -> _attr = array_merge( $this -> _attr, $attr );

    return $this;
  }
}

/**
 * Валидаторы
 */

class Text extends ValidateAbstract
{
  protected $_attr = [
    'required'  => true,
    'minlength' => 1,
    'textarea'  => false,
    'maxlength' => 65000,
  ];

  public function check( $data )
  {
    if ( $this -> _attr['required'] === false and $data === '' )
      return true;

    if ( $this -> _attr['required'] === true and $data === '' )
      return 'Вы не передали данные';

    if ( false === $this -> _attr['textarea'] and false !== strpos( $data, "\n" ) )
      return 'В Вашем тексте обнаружены переносы строк';

    $len = mb_strlen( $data );

    if ( $this -> _attr['minlength'] > $len )
      return "Ваш текст должен быть минимум {$this -> _attr['minlength']} символов";

    if ( $this -> _attr['maxlength'] < $len )
      return "Ваш текст должен быть максимум {$this -> _attr['maxlength']} символов";

    return true;
  }
}

class Enum extends ValidateAbstract
{
  protected $_attr = [
    'required'  => true,
    'values'    => [],
  ];

  public function check( $data )
  {
    if ( '' == $data and true === $this -> _attr['required'] )
      return 'Вы не выбрали данные' ;

    else if ( '' ==  $data and false === $this -> _attr['required'] )
      return true;

    if ( [] === $this -> _attr['values'] )
      return 'Ошибка разработки. Возможные значения не определены' ;

    if ( is_array( each( $this -> _attr['values'] )[1] ) )
    {
      $st = false;

      array_walk( $this -> _attr['values'], function( $value, $key ) use ( $data, &$st ) {
        if ( in_array( (string)$data, $value ) )
          $st = true;
      } );

      return $st ;
    }

    if ( ! in_array( (string)$data, $this -> _attr['values'] ) )
      return 'Переданный вариант списка не найден в нем.';

    return true;
  }
}

class Aids extends ValidateAbstract
{
//  protected $_type = ValidateAbstract::TYPE_FILE;
  protected $_type = ValidateAbstract::TYPE_ARRAY;

  public function check( $data )
  {
    foreach ( $data as $value )
    {
      if ( false === ctype_digit( $value ) )
        return 'Вы передали массив с текстом';
    }

    return true;
  }
}

class Id extends ValidateAbstract
{
  public function check( $data )
  {
    if ( ! $data )
      return 'Вы не передали ID';

    if ( ! ctype_digit( $data ) )
      return 'Вы передали ID который не есть числом';

    if ( $data > 4294967295 )
      return 'ID слишком большой';

    return true;
  }
}

class Name extends ValidateAbstract
{
  public function check( $data )
  {
    if ( ! $data )
      return 'Вы не передали имя';

    if ( mb_strlen( $data ) > 20 )
      return 'Имя не должно быть больше 20 символов';

    return true;
  }
}


/**
 * Класс филда. Используется для приема/валидации одного набора данных
 */
class Field
{
  /**
   * @var string название параметра которое надо получить и обработать с данных,
   * что приходят от пользователя. То есть, когда надо принять данные например
   * user_name с суперглобального массива _GET или _POST мы пишем:
   * $foo = $_GET['user_name'] или $bar = $_POST['user_name'] в этом случае
   * user_name и есть названием параметра который надо принять. Метод приема(get, post, etc)
   * определяется позже
   */
  protected $_name;

  /**
   * @var object ValidateAbstract объект валидатора который будет производить проверку
   * полученных данных
   */
  protected $_validate;

  /**
   * @var mixed свойство для хранения данных, что пришли от пользователя. Автоматом
   * заполняет свое значение в момент вызова метода getDataMethod
   */
  protected $_data;

  /**
   * @var string контейнер для записи теста ошибок при валидации данных филда. То,
   * что будет возвращать класс валидатор при проверке данных в случае ошибки будет
   * сохранено здесь
   */
  protected $_error;

  /**
   * Системные константы которые указывают допустимые методы приема данных от пользователя
   */
  const METHOD_POST    = 1;
  const METHOD_GET     = 2;
  const METHOD_COOKIE  = 3;
  const METHOD_REQUEST = 4;

  /**
   *
   * @param text $name название параметра
   * @param text $validate название класса валидатора
   * @param array $attr дополнительные атрибуты для валидатора
   */
  public final function __construct( $name, $validate, array $attr = [] )
  {
    $this -> _name     = $name;

    /**
     * Этот код создает "на лету" объект валидатора и устанавливает в него возможные
     * атрибуты, которые надо учитывать при валидации для написания универсальных валидаторов
     */
    $this -> _validate = new $validate;
    $this -> _validate -> setAttribute( $attr );
  }

  /**
   * @return mixed геттер свойства _data
   */
  public function getData(  )
  {
    return $this -> _data;
  }

  /**
   * @return text геттер свойства _error
   */
  public function getError(  )
  {
    return $this -> _error;
  }

  /**
   * @return text геттер свойства _name
   */
  public function getName(  )
  {
    return $this -> _name;
  }

  /**
   * Основной метод валидации данных
   *
   * @param int $method принимает одну из возможных констант Field::METHOD_*
   * @return boolean
   */
  public function validate( $method = Field::METHOD_POST )
  {
    /**
     * Получение данных с нужного суперглобального массива по имени _name
     * Данные после получения попадают в свойство _data
     */
    $this -> getDataMethod( $method );

    /**
     * Посылаем на валидацию данные $this -> _data в валидатор, который записан
     * в свойство _validate и получаем результат валидации
     */
    $status = $this -> _validate -> check( $this -> _data );

    /**
     * Если по результат валидации есть строкой, это означает, что метод валидации
     * данных check возвратил текст ошибки. Когда ошибок валидации нет, он возвращает
     * булево true
     */
    if ( is_string( $status ) )
    {
      $this -> _error = $status;
      return false;
    }
    else
      return true;
  }

  /**
   * Данный метод используется для получения единого массива с данными того
   * суперглобального массива, который нужен для приема данных. Далее эти данные
   * будут использованы в методе getDataMethod для получения нужных данных по их ключу
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   * @return array
   */
  protected function getAllDataFromMethod( $method )
  {
    switch ( $method )
    {
      case Field::METHOD_POST :    return $_POST;
      case Field::METHOD_GET :     return $_GET;
      case Field::METHOD_COOKIE :  return $_COOKIE;
      case Field::METHOD_REQUEST : return $_REQUEST;
      default : return [];
    }
  }

  /**
   * Метод который получает данные от пользователя
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   */
  protected function getDataMethod( $method )
  {
    /**
     * Получаем от валидатора тип приема данных(строка, массив или файл)
     */
    $type = $this -> _validate -> getType();

    /**
     * Получаем нужных суперглобальный массив с данными.
     */
    $data = $this -> getAllDataFromMethod( $method );

    /**
     * Перебираем типы данных, и получаем безопасно данные от пользователя в
     * зависимости от того типа данных, который нужен валидатору. Т.е. если
     * валидатор, который будет обрабатывать данные должен работать со строками,
     * этот метод должен принять данные как строку и передать их на валидатор, если
     * валидатор работает с массивом, соответственно метод должен принять данные
     * как массив.
     */
    switch ( $type )
    {
      case ValidateAbstract::TYPE_STRING:
        $this -> _data = ( isset( $data[$this -> _name] ) and is_string( $data[$this -> _name] ) )
          ? trim( $data[$this -> _name] ) : '';
        break;
      case ValidateAbstract::TYPE_ARRAY:
        $this -> _data = ( isset( $data[$this -> _name] ) and is_array( $data[$this -> _name] ) )
          ? $data[$this -> _name] : [];
        break;
      case ValidateAbstract::TYPE_FILE:
        $this -> _data = ( isset( $data[$this -> _name] ) ) ? $data[$this -> _name] : [];
        break;
      default : exit( 'Error! Undefined type' );
    }
  }
}


/**
 * Класс группы используется для удобства описания нескольких свойств, их валидации
 * и получения данных от пользователи и возможных ошибок.
 */
class Group
{
  /**
   * @var array в этом свойстве сохраняются в виде ассоциативного многомерного
   * массива объекты группы
   */
  protected $_fields = [];

  /**
   * @param array $a_fields описание филдов
   */
  public function __construct( array $a_fields )
  {
    /**
     * Перебор всех филдов и создание "на лету" объектов класса Field на основе
     * описания полей.
     */
    foreach ( $a_fields as $values )
    {
      $attr = ( isset( $values[2] ) ? $values[2] : [] );
      $this -> _fields[$values[0]] = new Field( $values[0], $values[1], $attr );
    }
  }

  /**
   * @return array метод для получения привычного массива $a_data
   */
  public function getAllData(  )
  {
    $a_data = [];

    foreach ( $this -> _fields as $field )
      $a_data[$field -> getName()] = $field -> getData();

    return $a_data;
  }

  /**
   * @return array метод для получения привычного массива $a_error
   */
  public function getAllError(  )
  {
    $a_error = [];

    foreach ( $this -> _fields as $field )
    {
      if ( is_string( $field -> getError(  ) ) )
        $a_error[$field -> getName()] = $field -> getError();
    }

    return $a_error;
  }

  /**
   * Метод что перебирает филды и поочередно посылает их на валидацию. Если хотя бы
   * один филд не пройдет валидацию, вся группа будет считаться как такая, что не прошла
   * валидацию
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   * @return boolean
   */
  public function isValid( $method = Field::METHOD_POST )
  {
    $valid = true;

    foreach ( $this -> _fields as $field )
    {
      if ( false === $field -> validate( $method ) )
        $valid = false;
    }

    return $valid;
   }

   /**
    * Метод для получения данных одного филда по его имени
    * @param string $name имя филда данные которого надо получить
    * @return mixed
    */
   public function getFieldData( $name )
   {
     return $this -> _fields[$name] -> getData();
   }

   /**
    * Метод для получения ошибки одного филда по его имени
    * @param string $name имя филда ошибку которого надо получить
    * @return mixed
    */
   public function getFieldError( $name )
   {
     return $this -> _fields[$name] -> getError();
   }
}

/**
 * Как с этим работать
 */

/**
 * Если надо от пользователя принять один набор данных, для этого удобнее использовать
 * класс Field в который на конструктор надо передать два/три параметра:
 * первый: имя параметра, например по старинке как принимали $foo = $_GET['имя параметра']
 * второй: имя класса валидатора который будет отвечать за валидацию
 * третий: он не обязательный но в нем могут передаваться дополнительные атрибуты
 * для валидации при использовании "универсальных" валидаторов таких как "Text"
 */

//$nid  = new Field( 'news_id', 'id' );
//$uid  = new Field( 'user_id', 'id' );
//$cid  = new Field( 'comment_id', 'id' );
//$name  = new Field( 'user_name', 'name' );
//
//$user_name  = new Field( 'user_name', 'text', ['required' => false, 'maxlength' => 20, 'minlength' => 2] );
//$user_sname = new Field( 'user_sname', 'text', ['maxlength' => 50] );
//$aids = new Field( 'a_int', 'aids' );
//$select = new Field( 'select', 'enum', ['values' => [
//  1,2,3,4,5,50,150
//]] );


/**
 * Создав класс филда, для того чтобы принять данные и проверить их, достаточно
 * вызвать метод -> validate и передать ему метод приема данных:
 */
//$nid -> validate();//Принимает по умолчанию данные с метода _POST
//$uid -> validate( Field::METHOD_GET );//Принимает данные с метода _GET
//$cid -> validate( Field::METHOD_COOKIE );//Принимает данные с метода _COOKIE

/**
 * Метод валидации возвращает булево значение true или false чтобы было удобнее
 * определять была ли успешно пройдена валидация, поэтому по "боевому" этот метод
 * лучше использовать в условиях вида:
 */
//if ( $name -> validate( Field::METHOD_GET ) )
//  echo 'Пользователь передал имя: ' . $name -> getData();
//else
//  echo 'Случилась ошибка:' . $name -> getError();

/**
 * Еще пример:
 */
//echo '<hr />';
//$user_id = new Field( 'user_id', 'id' );
//
//if ( $user_id -> validate() )
//  echo 'Вывод информации по пользователю ID: ' . $user_id -> getData();
//else
//  echo 'Случилась ошибка:' . $user_id -> getError();



/**
 * В случаях когда работаете с формами или надо принять несколько наборов данных
 * от пользователя, использовать филды не удобно, потому что для описания одного
 * филда надо создать для него вручную объект и при валидации группы филдов вызывать
 * поочередно метода validate столько раз, сколько данных надо принять. Например:
 */
//$user_id    = new Field( 'user_id',    'id' );
//$user_name  = new Field( 'user_name',  'name' );
//$user_sname = new Field( 'user_sname', 'text' );
//
//if ( $user_id -> validate() and $user_name -> validate() and $user_sname -> validate() )
//  Успех
//else
//  ошибка

/**
 * Поэтому в таких случаях удобнее использовать класс группы который содержит описание
 * всех наборов данных, которые надо принять. Например:
 */
//$group = new Group( [
//  [ 'user_id',    'id' ],
//  [ 'user_name',  'name' ],
//  [ 'user_sname', 'text', [ 'required' => false, 'maxlength' => 20 ] ],
//] );
//
/**
 * Метод isValid посылает на валидацию в сю группу тем методом, который передан
 * первым аргументом на его вход. По умолчанию работает метод POST. Метод возвращает
 * булево true/false которые аналогично методу validate класса Field удобнее всего
 * использовать в условиях
 */
//echo '<pre>';
//var_dump( $group -> isValid( Field::METHOD_GET ) );
//echo '</pre>';
//
/**
 * Это метод для получения привычного массива $a_error
 */
//echo '<pre>';
//print_r( $group -> getAllError() );
//echo '</pre>';
/**
 * Это метод для получения привычного массива $a_data
 */
//echo '<pre>';
//print_r( $group -> getAllData() );
//echo '</pre>';

/**
 * По боевому это удобнее писать так:
 */
//if ( isset( $_POST['submit_button'] ) and $group -> isValid( Field::METHOD_POST ) )
//{
//  // Выполняем успешную операцию либо с массивом переданных данных:
//  $a_data = $group -> getAllData();
//  $sql = "INSERT .... SET `user_name` = '{$a_data['user_name']}' ....";
//  // ... или бережем память и достаем нужные данные "на лету":
//  $sql = "INSERT .... SET `user_name` = '{$group -> getFieldData( 'user_name' )}' ....";
//}
//else
//{
//  // Выполняем вывод ошибо либо с массивом ошибок:
//  $a_error = $group -> getAllError();
//
//  //1
//  foreach ( $a_error as $name => $text )
//    echo "В поле {$name} найдено ошибку {$text} <br />";
//  //2
//    echo ( ( isset( $a_error['user_name'] ) ) ? '<span style="color: red">' . $a_error['user_name'] . '</span><br />' : '' );
//
//  // ...или же бережем память и достаем нужные данные "на лету":
//    echo ( ( $group -> getFieldError( 'user_name' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'user_name' ) . '</span><br />' : '' );
//}