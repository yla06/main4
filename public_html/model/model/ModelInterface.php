<?php
/**
 * Используя интерфейс мы указываем какие метода и константы должны быть ОБЯЗАТЕЛЬНО
 * объявлены во ВСЕХ классах которые будут реализовывать этот интерфейс. В данном
 * примере написаны два класса которые имеют одинаковый интерфейс для работы с данными
 * которые сохранены в БД и в файлах.
 */
interface ModelInterface
{
  public function __construct(  );
  public function insert(  );
  public function update(  );
  public function delete( $id );
  public static function selectAll(  );
  public static function selectById( $id );
  public function save(  );
  public function fill( $data );
}