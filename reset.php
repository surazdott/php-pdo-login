<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

require 'config/init.php';
$user = new User();

if(isset($_GET['token']) && !empty($_GET['token'])) {

	$token = sanitize($_GET['token']);
	$user_info = $user->getUser(['password_reset_token' => $token]);
	/**
	* Sanitize function clean your code
	*/
	if (!$user_info) {
		redirect('login', 'error', 'Invalid reset token, please send again.');
	} else {
		// Reset password of user by id
		$_SESSION['reset_user_id'] = $user_info[0]->id;
		// Reset the password of the user if token is right
		$_SESSION['reset_password_token'] = $token;

		?>

		<!DOCTYPE html>
		<html>
		<head>
			<title>Password Reset</title>
			<link rel="stylesheet" type="text/css" href="<?php echo CMS_CSS.'bootstrap.min.css' ?>">
		</head>
		<body>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h4 class="text-center">Password Reset Form</h4>
						<hr>
					</div>
					<div class="col-md-12">
						<form action="process/reset" class="form form-horizontal" method="post">
							<div class="form-group row">
								<label for="" class="col-sm-3">New Password:</label>
								<div class="col-sm-9">
									<input type="password" required name="password" class="form-control" id="password">
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3">Confirm Password:</label>
								<div class="col-sm-9">
									<input type="password" required name="re_password" class="form-control" id="re_password">
									<span class="hidden" id="err_pass"></span>
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3"></label>
								<div class="col-sm-9">
									<button class="btn btn-success" id="submit">
										Reset password
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<script type="text/javascript" src="<?php echo CMS_JS.'jquery.min.js' ?>"></script>
			<script>
				$('#re_password').keyup(function(){
					var pass = $('#password').val();
					var re_pass = $('#re_password').val();
					if(pass != re_pass){

						$('#err_pass').html('Password does not match.').removeClass('hidden').addClass('alert-danger');

						$('#submit').attr('disabled', 'disabled');
					} else {
						$('#err_pass').html('').removeClass('alert-danger').addClass('hidden');
						$('#submit').removeAttr('disabled', 'disabled');
					}
				});
			</script>


		</body>
		</html>

	<?php	
	}

} else {
	redirect('login', 'error', 'Token not found.');
}