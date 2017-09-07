<?php
/**
 * Подключаем файл с интерфейсом
 */
require_once 'ModelInterface.php';

/**
 * Абстрактный класс ModelAbstract это общий функционал двух будущих классов для
 * работы с адаптерами БД и ФС. По сути эти два класса унаследуют этот класс и имеют таким
 * образом одинаковый функционал. То, чем классы должны отличаться описывается в
 * дочерних классах. То что должно быть одинаковым для двух адаптеров, описано тут.
 */
abstract class ModelAbstract implements ModelInterface
{
  /**
   * @var string Имя таблицы в БД или название файла где сохранены данные модели
   */
  protected $_target;

  /**
   * @var array массив правил или описание содержимого модели(см.модели Blog, Comment)
   */
  protected $_rules;

  /**
   * @var array массив для сохранения имен алиасов которые заполнены в процессе работе с моделью.
   */
  protected $_fields = [];

  /**
   * При работе с моделью мы в основном работем с алиасами полей при этом
   * названия столбцов не используем. Выходит что при обращении к $model -> title
   * чтение значения происходит со столбца blog_title в таблице БД согласно опсиания
   * одели в _rules. Когда происходит выборка данных с БД возвращается массив с
   * именами реальных столбцов в БД а не алиасы. Поэтому в этом массиве сохраняется чтото типа:
   * blog_title => title
   *
   * чтобы удобнее было находить имена алиасов которым пренадлежат данные что выбираются
   *
   * @var array массив в котором сохранены реверсные названия полей.
   */
  protected $_reverseFields;

  public function __construct(  )
  {
    /**
     * При создании модели создаются реверсалиасы
     */
    if ( ! isset( $this -> _reverseFields ) )
    {
      foreach ( $this -> _rules as $alias => $rule )
        $this -> _reverseFields[$rule[0]] = $alias;
    }
  }

  /**
   * При записи в модель свойства алиаса которого в ней нет, вызывается магический
   * метод который проверяет наличие алиаса в описании модели в _rules
   * Например: $model -> foo = 1;
   * @param string $name
   * @param string $value
   */
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

  /**
   * Метод для сохранения или замены данных в модели. Если в модели есть ID
   * vетод отработает на змену иначе на вставку данных:
   * $model = new Model;
   * $model -> id = 1;
   * $model -> foo = 2;
   * $model -> save(); // Замена
   *
   * $model = new Model;
   * $model-> foo = 2;
   * $model -> save(); // Вставка
   */
  public function save(  )
  {
    if ( false !== array_search( 'id', $this -> _fields ) )
      return $this -> update (  );
    else
      return $this -> insert(  );
  }

  /**
   * Получение закрытого свойства модели. Используется только моделью.
   * @param string $name
   * @return mixed
   */
  protected static function getProperty( $name )
  {
    $class_name = get_called_class();// Имя текущей модели
    $tmp = new $class_name;// Создание модели

    $class = new ReflectionClass( $tmp );// Создание объекта класса ReflectionClass
    $property = $class -> getProperty( $name );// Запрос значения свойства модели
    $property -> setAccessible( true );// Уставнока на чтение закрітого свойства

    return $property -> getValue( $tmp );// Получение значения
  }

  /**
   * Заливка или создание алиасов модели при выборке данных.
   * Этот метод вызывается привыборке одного ряда в БД и автоматом создает
   * по именам алиасов свойства и заполняет их данными полученными при выборке
   *
   * @param array $a_data
   * @return $this
   */
  public function fill( $a_data )
  {
    foreach ( $a_data as $name => $data )
      $this -> {$this -> _reverseFields[$name]} = $data;

    return $this;
  }

  /**
   * Получение массива выбранных данных
   * @return array
   */
  public function fetch(  )
  {
    $return = [];

    foreach ( $this -> _fields as $name )
      $return[ $this -> _rules[$name][0]] = $this -> $name;

    return $return;
  }
}