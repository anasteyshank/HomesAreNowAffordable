<?php 
	/*
		Group 18
		WEBD3201
		December 8, 2019
	*/
	$title = "Request new password";
	$file = "password-request.php";
	$description = "This is a page for requesting a new password of a web site created for WEBD3201";
	$date = "December 8, 2019";
	$banner = "Request new password";

	require 'header.php';
	
	if (isset($_SESSION['user'])) { redirect("index.php"); }

	$user_id = "";
	$email = "";
	$user_id_msg = "";
	$email_msg = "";
	$error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$user_id = trim($_POST['user_id']);
		$email = trim($_POST['email']);

		if (strlen($user_id) == 0) { $user_id_msg = "Please enter your user ID"; $email = ""; }
		else if (!is_user_id($user_id))
		{
			$user_id = ""; $email = "";
			$user_id_msg = "Login not found in our database";
		}
		else if (!is_user_email($user_id, $email)) { $email = ""; $email_msg = "Email not found in our database"; }
		else
		{
			// $new_passwd = substr(uniqid(), 5);
			// $mail_to = $email;
			// $mail_subject = "HANA: New Password";
			// $mail_body = "Hello!\nHere's your new generated password: " . $new_passwd;
			// $headers = "from: " . WEBSITE_EMAIL . "\r\n";
			// if (mail($mail_to, $mail_subject, $mail_body, $headers))
			// {
			// 	update_password(array($new_passwd, $user_id));
			// 	$_SESSION['email_sent'] = "Please check your email for the new password";
			// 	redirect("login.php");
			// }
			// else { $error = "The massage wasn't delivered"; }
			$_SESSION['email_sent'] = "Please check your email for the new password";
			redirect("login.php");
		}
	}
?>
<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Request New Password</p>
		<label class="pull-left">User ID:</label>
		<p><input class="form-control mb-4" type="text" name="user_id" value="<?php echo $user_id; ?>" placeholder="User ID"/></p>
		<?php fields_warning_message($user_id_msg) ?>
		<label class="pull-left">Email Address:</label>
		<input class="form-control mb-4" type="text" name="email" value = "<?php echo $email; ?>" placeholder="Email"/>
		<?php fields_warning_message($email_msg); ?>
		<p><button class="btn btn-info btn-block my-4" type="submit" value="Request" name="request">Request Password</button></p>
		<?php fields_warning_message($error); ?>
	</form>
</div>
<?php include 'footer.php'; ?>