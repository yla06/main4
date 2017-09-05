<?php
function load_template( $name )
{
  if ( file_exists( MC_CORE . "/template/{$name}.php" ) )
    require_once MC_CORE . "/template/{$name}.php";
  else
    echo 'Шаблон не найден';
}

function setInfo( $text )
{
  $_SESSION['infoblock']['info'][] = $text;
}

function setError( $text )
{
  $_SESSION['infoblock']['error'][] = $text;
}

function setSuccess( $text )
{
  $_SESSION['infoblock']['success'][] = $text;
}

function setWarning( $text )
{
  $_SESSION['infoblock']['warning'][] = $text;
}

function getInfoBlock(  )
{
  if ( ! isset( $_SESSION['infoblock'] ) )
    return true;

  foreach ( $_SESSION['infoblock'] as $type => $a_text )
  {
    switch ( $type )
    {
      case 'info':    $color = 'blue';   break;
      case 'error':   $color = 'yellow'; break;
      case 'success': $color = 'green';  break;
      case 'warning': $color = 'red';    break;
    }

    echo '<div style="background-color: '.$color.'; border: 1px solid black;">' . implode( '<br /><br />', $a_text ) . '</div>';
  }

  unset( $_SESSION['infoblock'] );
}

function check_admin_auth(  )
{
  if ( $_SESSION['admin_auth'] )
    return true;
  else
  {
    setWarning( 'Авторизация Администратора не найдена' );
    exit( header( 'Location: admn.php' ) );
  }
}