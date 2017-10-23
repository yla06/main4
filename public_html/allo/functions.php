<?php
function mf_get_time(  )
{
  return 'Time:<b>' . round( microtime( true ) - HEADTIME, 4 ) . '</b> sec.<br />';
}

function mf_get_memory(  )
{
  return 'Memory:<b>' . ( round( ( memory_get_usage(  ) - HEAD_MEMORY_USG ) / (1024 * 2), 3 ) ) . '</b> Kb<br />';
}

function start_session()
{
  if ( session_status() == PHP_SESSION_NONE )
  {
    session_start();
  }
}

function setInfo( $text )
{
  start_session();
  $_SESSION['infoblock']['info'][] = $text;
}

function setError( $text )
{
  start_session();
  $_SESSION['infoblock']['error'][] = $text;
}

function setSuccess( $text )
{
  start_session();
  $_SESSION['infoblock']['success'][] = $text;
}

function setWarning( $text )
{
  start_session();
  $_SESSION['infoblock']['warning'][] = $text;
}

function getInfoBlock(  )
{
  start_session();
  if ( ! isset( $_SESSION['infoblock'] ) )
    return true;

  echo '<div class="container">
          <div class="row">
            <div class="col-md-12">';

  foreach ( $_SESSION['infoblock'] as $type => $a_text )
  {
    switch ( $type )
    {
      case 'info':    $color = 'bg-primary';   break;
      case 'error':   $color = 'bg-warning'; break;
      case 'success': $color = 'bg-success';  break;
      case 'warning': $color = 'bg-danger';    break;
    }

    echo '<p class="'.$color.'">' . implode( '<br /><br />', $a_text ) . '</p>';
  }

  echo '</div>';
  echo '</div>';
  echo '</div>';

  unset( $_SESSION['infoblock'] );
}

function stop( $text )
{
  exit( header( "HTTP/1.0 404 {$text}" ) );
}

function array2csv( array &$array )
{
  if ( count( $array ) == 0 )
    return null;

  ob_start();
  $df = fopen( "php://output", 'w' );
  fputcsv( $df, array_keys( reset( $array ) ), ';', '"' );

  foreach ( $array as $row )
    fputcsv( $df, $row, ';', '"' );

  fclose( $df );
  return ob_get_clean();
}