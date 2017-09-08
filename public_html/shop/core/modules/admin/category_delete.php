<?php
$group = new Group( [
  [ 'category_id', 'id' ],
  [ 'token', 'token' ],
] );

if ( false === $group -> isValid( Field::METHOD_GET ) )
{
  setError( 'Категория не удалена. Не передан идентификатор или токен безопасности' );
  exit( header( 'Location: ?module=category' ) );
}

$sql = "DELETE FROM `sm_category` WHERE `category_id` = '" . intval( $group -> getFieldData( 'category_id' ) ) . "' LIMIT 1";

if ( mysql_query( $sql ) )
{
  if ( $rows = mysql_affected_rows() )
    setSuccess( 'Категория успешно удалена' );
  else
    setError( 'Категория не удалена. Возможно она была удалена раньше' );
}
else
  setError( 'Данную категорию нельзя удалить так как в ней есть товары' );

exit( header( 'Location: ?module=category' ) );