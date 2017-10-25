<?php
echo '<pre>';
print_r( gethostbyaddr ( $_SERVER['REMOTE_ADDR'] ) );
echo '</pre>';
echo '<pre>';
print_r( $_SERVER );
echo '</pre>'; 