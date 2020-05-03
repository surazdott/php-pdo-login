<?php $page_title = 'Admin'; // page name eg Admin ?>
<?php require 'inc/header.php';  ?>
<?php 
 //debugger($_SESSION, true);
  if(isset($_SESSION['token'])  || isset($_COOKIE['_auth_user'])) {
    redirect('dashboard', 'success', 'You are already logged in.');
  }
?>

    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php flash(); ?>
            <form action="process/login" method="post">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="username" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password" />
              </div>
              <div class="checkbox">
                <input type="checkbox" name="remember_me" value="1"> Remember Me
              </div>
              <div>
                <button class="btn btn-default submit">Log in</button>
                <a class="reset_pass" href="reset">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <p>&copy; <?php echo date("Y"); ?> Powered By <a href="<?php echo SITE_URL; ?>"><?php echo SITE_NAME; ?></a></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>

