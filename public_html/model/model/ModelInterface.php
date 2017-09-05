<?php
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