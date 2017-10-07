<?php

echo '<pre>';
print_r( json_decode( file_get_contents( 'http://main4.phpstep.com.ua/api_rand.php?apikey=123&count=5&prefix=ABC' ), true ) );
echo '</pre>';
