<?php
$group = new Group( [
  [ 'goods_id', 'id' ],
  [ 'token', 'token' ],
] );

if ( false === $group -> isValid( Field::METHOD_GET ) )
{
  setError( 'Товар не удален. Не передан идентификатор или токен безопасности' );
  exit( header( 'Location: ?module=goods' ) );
}

$sql = "DELETE FROM `sm_goods` WHERE `goods_id` = '" . intval( $group -> getFieldData( 'goods_id' ) ) . "' LIMIT 1";

if ( mysql_query( $sql ) )
{
  if ( $rows = mysql_affected_rows() )
    setSuccess( 'Товар успешно удален' );
  else
    setError( 'Товар не удален. Возможно он был удален раньше' );
}
else
  setError( 'Данный товар нельзя удалить так как он есть в истории' );

exit( header( 'Location: ?module=goods' ) );