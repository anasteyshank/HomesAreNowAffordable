<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Change Password";
	$file = "change-password.php";
	$description = "This is a page for changing password of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Change Password";

	require 'header.php';

	set_warning_message(false);
	$old_password = "";
	$password = "";
	$confirm_password = "";
	$old_pass_msg = "";
	$pass_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$old_password = trim($_POST['old_password']);
		$password = trim($_POST['password']);
		$confirm_password = trim($_POST['confirm_password']);
		$error = false;

		if ($old_password == "") { $old_pass_msg = "Please enter your old password."; $error = true; }
		else
		{
			$result = get_user_information($_SESSION['user']['user_id'], hash(HASH_TYPE, $old_password));
			if (pg_num_rows($result) <= 0) { $old_pass_msg = "The password is incorrect. Please try again."; $error = true; }
		}
		
		if (strcmp($password, $confirm_password) <> 0) { $pass_msg = "The password and the confirm password were not the same"; $error = true; }
		else if (strlen($password) == 0) { $pass_msg = "Please enter your new password"; $error = true; }
		else if (strlen($password) < MINIMUM_PASSWORD_LENGTH) { $pass_msg = "Your password must be at least " . MINIMUM_PASSWORD_LENGTH . " characters long"; $error = true; }
		else if (strlen($password) > MAXIMUM_PASSWORD_LENGTH) { $pass_msg = "Your password cannot be more than " . MAXIMUM_PASSWORD_LENGTH . 	" characters long"; $error = true; }

		if (!$error)
		{
			update_password(array(hash(HASH_TYPE, $password), $_SESSION['user']['user_id']));
			if ($_SESSION['user']['user_type'] == ADMIN) { redirect('admin.php'); }
			else if ($_SESSION['user']['user_type'] == AGENT) { redirect('dashboard.php'); }
			else { redirect('welcome.php'); }
		}
	}
?>

<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Change Password</p>
		<p class="pull-left font-weight-bold">User ID:</p>
		<p class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['user']['user_id']; ?></p>
		<br/><hr/>
		<input class="form-control mb-4" type="password" name="old_password" value="" placeholder="Old Password"/></p>
		<?php fields_warning_message($old_pass_msg) ?>
		<input class="form-control mb-4" type="password" name="password" value="" placeholder="New Password"/></p>
		<?php fields_warning_message($pass_msg) ?>
		<input class="form-control mb-4" type="password" name="confirm_password" value="" placeholder="Confirm Password"/></p>
		<p><button class="btn btn-info btn-block my-4" type="submit" value="Submit" name="login">Submit</button>&nbsp;</p>
	</form>
</div>

<?php include 'footer.php'; ?>