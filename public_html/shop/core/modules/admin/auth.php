<?php
$group = new Group( [
  [ 'login', 'text' ],
  [ 'password', 'password' ],
] );

if ( isset( $_POST['submit_auth'] ) )
{
  if ( $group -> isValid( Field::METHOD_POST )  )
  {
    if ( $group -> getFieldData( 'login' ) == MC_ADMIN_LOGIN and $group -> getFieldData( 'password' ) == MC_ADMIN_PASSWORD )
    {
      $_SESSION['admin_auth'] = true;
      exit( header( 'Location: admn.php?module=cabinet') );
    }
    else
      setError ( 'Пароль введен не верно' );
  }
  else
    setError ( 'В данных найдены ошибки' );
}

?>
<section class="login-content">
  <div class="login-content-wrapper">
    <div class="container">
						<div class="row">
        <div class="login-content-inner">
          <div id="customer-login">
            <div id="login" class="">

              <form id="customer_login1" action="" method="post" accept-charset="UTF-8">
                <label for="login" class="label">Login</label>
                <input type="text" name="login" id="login" class="text" value="<?= ( ( $group -> getFieldData( 'login' ) ) ? htmlspecialchars( $group -> getFieldData( 'login' ) ) : '' );?>">

                <?= ( ( $group -> getFieldError( 'login' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'login' ) . '</span><br />' : '' );?>

                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password" class="text" size="16">
                <?= ( ( $group -> getFieldError( 'password' ) ) ? '<span style="color: red">' . $group -> getFieldError( 'password' ) . '</span><br />' : '' );?>

                <div class="action_bottom">
                  <input class="btn" name="submit_auth" type="submit" value="Sign In">
                </div>
              </form>
            </div>
          </div>
        </div>
						</div>
    </div>
  </div>
</section>