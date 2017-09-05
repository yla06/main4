<?php
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