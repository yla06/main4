<?php
require_once 'bootstrap.php';

if ( isset( $_SESSION['auth'] ) )
  echo '<a href="add.php">Добавить запись</a><hr />';
else
{
  echo '<a href="authorize.php">Авторизация</a><hr />';
  echo '<a href="register.php">Регистрация</a><hr />';
}

getInfoBlock(  );

$sql = "SELECT `b`.*, `u`.`user_login` FROM `" . DB_PREFIX . "blog` AS `b`
  INNER JOIN `" . DB_PREFIX . "user` AS `u`
    ON `u`.`user_id` = `b`.`blog_user_id`
  ";

if ( $result = mysql_query( $sql ) )
{
  if ( mysql_num_rows( $result ) )
  {
    while ( $row = mysql_fetch_assoc( $result ) )
    {
      echo '<a href="view.php?blog_id=' . $row['blog_id'] . '">Просмотр</a> |';

      if ( isset( $_SESSION['auth'] ) and $_SESSION['auth'] == $row['blog_user_id'] )
      {
        echo '<a href="edit.php?blog_id=' . $row['blog_id'] . '">Редактировать</a> |';
        echo '<a href="delete.php?blog_id=' . $row['blog_id'] . '&token=' . session_id(  ) . '">Удалить</a>';
      }

      echo '<br />';
      echo '<h2>' . htmlspecialchars( $row['blog_title'] ) . '</h2>';
      echo '<h6>Автор: ' . htmlspecialchars( $row['user_login'] ) . '</h6>';
      echo '<div>' . htmlspecialchars( $row['blog_text'] ) . '</div><hr />';
    }
  }
  else
    echo 'Блогов нет';
}
else
  exit( mysql_error(  ) );