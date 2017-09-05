<section class="login-content">
  <div class="login-content-wrapper">
    <div class="container">
						<div class="row">
        <div class="login-content-inner">
          <div id="customer-login">
            <div id="login" class="">
              <?php if ( isset( $_POST['submit_auth'] ) ): ?>
              <div class="alert alert-danger">
              Пароль не найден
              </div>
              <?php endif ?>
              <form id="customer_login1" action="" method="post" accept-charset="UTF-8">
                <label for="login" class="label">Login</label>
                <input type="text" name="login" id="login" class="text">
                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password" class="text" size="16">
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