<?php
header( 'Content-Type: text/html; charset=win-1251' );

//for( $page = 1300; $page > 1299; $page-- )
  $data = file_get_contents( 'http://bash.im/index/' . $page );

preg_match_all( '#\<div class\=\"text\"\>(.+)\<\/div\>#', $data, $m );

foreach ( $m[1] as $row )
{
  echo '<div style="border: 1px solid red; padding: 10px; margin: 20;">' .  $row . '</div>';
}
