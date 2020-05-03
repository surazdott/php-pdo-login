<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

require '../config/init.php';
$user = new User();

if(isset($_POST) && !empty($_POST)){
	if(empty($_POST['password']) || empty($_POST['re_password'])){
		redirect('../reset?token='.$_SESSION['reset_password_token'], 'error', 'Password or re-password cannot be empty.');
	}

	if($_POST['password'] != $_POST['re_password']){
		redirect('../reset?token='.$_SESSION['reset_password_token'], 'error', 'Password and re-password are not same.');
	}

	$token = sanitize($_SESSION['reset_password_token']);
	// Sanitize clean the code	
	$user_info = $user->getUser(['password_reset_token' => $token]);
	
	if(!$user_info){
		redirect('../reset', 'error', 'Invalid reset token. Please send again.');
	}
	
	$enc_password = sha1($user_info[0]->email.$_POST['password']);

	$data = array(
		'password' => $enc_password,
		'password_reset_token' => ''
	);
	$success = $user->updateUser($data, $user_info[0]->id);
	if($success){
		
		if($user_info[0]->role == 'Admin'){
			redirect('../cms', 'success', 'Password changed successfully.');
		} else  {
			redirect('../login', 'success', 'Password changed successfully.');
		}

	} else {
		redirect('../reset?token='.$token, 'error', 'Sorry! There was problem while updating password. Please contact our admin.');
	}
	
} else {
	redirect('../login','error', 'Unauthorized access.');
}
