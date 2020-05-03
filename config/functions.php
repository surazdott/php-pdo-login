<?php

/** 
 * @Package: Login
 * @Author: SurajDott
 * @Date: 2020-05-01
*/

/* Print the debugger in any page and data */
function debugger($data, $is_die = false) {
	echo "<pre style='color:#FF0000'>";
	print_r($data);
	echo "</pre>";
	if($is_die) {
		exit;
	}
}

/* Function for load Current Page */
function getCurrentPage() {
	return pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
	/**
	* $_SERVER['PHP_SELF'] gives current running page full path
	* pathinfo gives loaded file information with returnning in array..but we need file name..we can find file name and base name from pathinfo
	* PATHINFO_FILENAME gives file name removing rextension(index.php into index)
	*/

}

/* session message and redirection */
function redirect($path, $session_key = null, $session_msg = null) {
	if(isset($session_key) && !empty($session_key)) {
		$_SESSION[$session_key] = $session_msg;
	}
	@header('location: '.$path);
	exit;
	/**
	* redirection session key should be null, when there are no error while logging
	* session message sgould be null if there is no error wwhile logging
	* but if there is a error, session key value becomes change and it store the $session message
	* session message like Unauthorized access, error logging, wrong username and password
	* if there is error while looging, it redirect into login page
	*/
}

/* function to print the error message */
function flash() {
	if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
		echo "<p class='alert alert-success'>".$_SESSION['success']."</p>";
		unset($_SESSION['success']);
	}

	if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
		echo "<p class='alert alert-danger'>".$_SESSION['error']."</p>";
		unset($_SESSION['error']);
	}

	if(isset($_SESSION['warning']) && !empty($_SESSION['warning'])) {
		echo "<p class='alert alert-warning'>".$_SESSION['warning']."</p>";
		unset($_SESSION['warning']);
	}
	/**
	* flash is defined as a function to print the session messages l
	* Like error login..wrong username andd wrong password
	* Messages are set according to the login conditions 
	* So, session is used to get the login current situation and message
	*/

	?>

	<script type="text/javascript">
		setTimeout(function() {
			$('.alert').slideUp('slow');
		}, 3000);
		/**
		* script is for admin login page while logging
		* script destroyed the message after some time
		* where .alter is class name which is common is login form(index page)
		* animation = slideUp and destoryed time is 3sec(must be write in milisecond)
		*/
	</script>

	<?php
}

function randomString($leng = 100) {
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str_len = strlen($chars);
	$random = '';
	for($i=0; $i<$leng; $i++) {
		$random .= $chars[rand(0, $str_len-1)];

	/**
	* for loop for 100 lenghth charector
	* $random .= $chars[random(0, $str_len-1)]; to generate random number starting from 0 
	*/
	}

	return $random;
}

function sendMessage($to, $sub, $msg, $mail) {

    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.mailtrap.io'; 
    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'fc8640f49120ed';
    // SMTP username
    $mail->Password = '1793213539659d';
    // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('no-reply@login.com', 'No-Reply Login System');
    // Receiver
    $mail->addAddress($to);
    // Name is optional

    /**
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    */

    /*Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    */

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $sub;
    $mail->Body    = $msg;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    return $mail->send();

}

function sanitize($str) {
	$str = strip_tags($str);
	$str = stripslashes($str);
	$str = rtrim($str);
	/**
	* Sanitize should be clean
	* strip_tags clean the tag from string make the code clean
	* stripslashes clean or remove slashes and remove the special charectors
	* trim remove the multiple spaces strings
	* rtrim means recorship trim and it removes the multiple spaces in strings
	*/

	return $str;
	
}