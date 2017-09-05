<?php

require_once 'bootstrap.php';

$data = unserialize( file_get_contents( 'blog.dat' ) );


foreach ( $data as $key => $row )
{
  echo '<a href="view.php?key=' . $key . '">Просмотр</a> |';

  if ( isset( $_SESSION['auth'] ) )
  {
    echo '<a href="edit.php?key=' . $key . '">Редактировать</a> |';
    echo '<a href="delete.php?key=' . $key . '&amp;token=' . session_id() . '">Удалить</a> |';
  }


  echo '<br />';
  echo '<h2>' . htmlspecialchars( $row[ 'title' ] ) . '</h2>';
  echo '<div>' . htmlspecialchars( $row[ 'text' ] ) . '</div><hr />';
}


