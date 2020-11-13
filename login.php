<?php 
	/*
		Group 18
		WEBD3201
		September 13, 2019
	*/
	$title = "Login Page";
	$file = "login.php";
	$description = "This is the login page of the web site created for WEBD3201";
	$date = "September 13, 2019";
	$banner = "WEBD3201 - Login Page";
	
	require 'header.php';
	
	if (isset($_SESSION['user']))
	{
		redirect("index.php");
	}

	$error = "";
	$user_id = "";
	$password = "";
	$db_message = "";
	$info_message = "";
	$user_id_msg = "";
	$pass_msg = "";

	if (isset($_COOKIE['LOGIN_COOKIE']))
	{
		$user_id = $_COOKIE['LOGIN_COOKIE'];
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$user_id = trim($_POST['user_id']);
		$password = trim($_POST['password']);
		$is_valid = true;

		if ($user_id == "") { $user_id_msg = "Please enter your user ID."; $is_valid = false; }
		if ($password == "") { $pass_msg = "Please enter your password."; $is_valid = false; }

		if ($is_valid)
		{
			$db_message = "";
			$info_message = "";
			
			$result = get_user_information($user_id, hash(HASH_TYPE, $password));

			if (pg_num_rows($result) > 0) 
			{
				$db_row = pg_fetch_assoc($result);

				$db_row_person = pg_fetch_assoc(get_user_personal_information($user_id));

				if ($db_row['user_type'] == ADMIN || $db_row['user_type'] == CLIENT || $db_row['user_type'] == AGENT)
				{
					$_SESSION['user'] = $db_row;
					$_SESSION['person'] = $db_row_person;
					update_last_access($user_id);
					setcookie("LOGIN_COOKIE", $user_id, time() + COOKIE_LIFESPAN);
				}
				
				if ($db_row['user_type'] == ADMIN) { $_SESSION['logged_in'] = true; redirect('admin.php'); }
				else if ($db_row['user_type'] == CLIENT) { $_SESSION['logged_in'] = true; redirect('welcome.php'); }
				else if ($db_row['user_type'] == AGENT) { $_SESSION['logged_in'] = true; redirect('dashboard.php'); }
				else if ($db_row['user_type'] == PENDING) { $info_message = "Your account has not been approved yet."; }
				else if ($db_row['user_type'] == DISABLED || $db_row['user_type'] == DISABLED_AGENT) { $_SESSION['disabled_user'] = "Your account has been suspended"; redirect("aup.php"); }

				$user_id = "";
			}
			else
			{
				$db_message = "Login/password not found in our database";
			}
		}
	}
?>
<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Log in</p>
		<label class="pull-left">User ID:</label>
		<p><input class="form-control mb-4" type="text" name="user_id" value="<?php echo $user_id; ?>" placeholder="User ID"/></p>
		<?php fields_warning_message($user_id_msg) ?>
		<label class="pull-left">Password:</label>
		<p><input class="form-control mb-4 " id="defaultLoginFormPassword" type="password" name="password" value="" placeholder="Password"/></p>
		<?php fields_warning_message($pass_msg) ?>
		<a href="password-request.php">Forgot Password?</a><br/>
		New User? <a href="register.php">Create an account</a>.
		<p><button class="btn btn-info btn-block my-4" type="submit" value="Login" name="login">Log in</button></p>
		<p><?php 
			echo $db_message; 
			echo $info_message; 
			if (isset($_SESSION['logout_msg']))
			{
				echo $_SESSION['logout_msg'];
				unset($_SESSION['logout_msg']);
			}
			else if (isset($_SESSION['warning_msg']))
			{
				echo $_SESSION['warning_msg'];
				unset($_SESSION['warning_msg']);
			}
			else if (isset($_SESSION['register_msg']))
			{
				echo $_SESSION['register_msg'];
				unset($_SESSION['register_msg']);
			}
			else if (isset($_SESSION['email_sent']))
			{
				echo $_SESSION['email_sent'];
				unset($_SESSION['email_sent']);
			}
		?></p>
	</form>
</div>
<?php include 'footer.php'; ?>
