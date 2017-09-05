<?php
unset( $_SESSION['admin_auth'] );
exit( header( 'Location: index.php' ) );
