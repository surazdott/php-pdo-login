<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

require $_SERVER['DOCUMENT_ROOT'].'/login/config/config.php';
require CONFIG_PATH.'functions.php';
require CLASS_PATH.'Database.php';
require CLASS_PATH.'User.php';
require $_SERVER['DOCUMENT_ROOT'].'/login/assets/plugins/PhpMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/login/assets/plugins/SMTP.php';

$mail = new PHPMailer(true);
// Passing 'true' enables exceptions

$user = new User();

if(isset($_POST) && !empty($_POST)) {
	$user_name = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL);
	
	if(!$user_name) {
		redirect('../reset', 'error', 'Invaid username type. Username should be email.');
	}

	$user_info = $user->getUserByUsername($user_name);

	// if condition for user not found
	if($user_name != $user_info[0]->email) {
		redirect('../reset', 'error', 'Username or email not found.');
	} else {

		$reset_token = randomString(100);

		$args = array(
				'password_reset_token'	=> $reset_token
		);

		$user->updateUser($args, $user_info[0]->id);

		$message = "Dear ".$user_info[0]->full_name."! <br>";
		$message .= "You have requested for the password change. If you want to change the password, please click the link below: <br>";
		$message .= "<a href='".SITE_URL.'reset?token='.$reset_token."'>".SITE_URL.'reset?token='.$reset_token."</a>";
		$message .= "<br> If you did not request for the password change, please ignore this messsage.<br>";
		$message .= "Regards,<br>";
		$message .= "Meropasal.com";

		$mail = sendMessage($user_info[0]->email, "Paaword rest link", $message, $mail);

		if($mail) {
			redirect('../', 'success', "Email has been sent to your account for password reset.");
		} else {
			redirect('../reset', 'error', 'Sorry! There was problem while sending you email at this moment. Please try again after sometimes.');
		}
	}

	debugger($mail, true);

} else {
	redirect('../reset', 'warning', 'Provide your username.');
}
