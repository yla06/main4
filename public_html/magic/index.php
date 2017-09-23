<?php

require_once 'ImageLib.php';

$image = new ImageLib( '3.jpg' );

$image -> sepia();

$image -> save( 'files/1.png' );

header( 'Content-Type: image/png' );
echo file_get_contents( 'files/1.png' );