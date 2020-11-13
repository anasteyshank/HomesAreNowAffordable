<?php 
	/*
		Group 18
		WEBD3201
		October 27, 2019
	*/
	$title = "Register Page";
	$file = "register.php";
	$description = "This is the register page of the web site created for WEBD3201";
	$date = "September 30, 2019";
	$banner = "WEBD3201 - Register Page";

	require 'header.php';

	if (isset($_SESSION['user']))
	{
		$_SESSION['warning_msg'] = "You are already logged in!";
		redirect('update.php');
	}
	
	$login = "";
	$password = "";
	$confirm_password = "";
	$email = "";
	$salutations = "";
	$first_name = "";
	$last_name = "";
	$address1 = "";
	$address2 = "";
	$city = "";
	$provinces = "";
	$postal_code = "";
	$primary_phone = "";
	$secondary_phone = "";
	$fax_number = "";
	$preferred_contact_method = "";
	$is_agent = false;
	
	$login_msg = "";
	$pass_msg = "";
	$confirm_pass_msg = "";
	$email_msg = "";
	$first_name_msg = "";
	$last_name_msg = "";
	$address1_msg = "";
	$address2_msg = "";
	$city_msg = "";
	$postal_code_msg = "";
	$primary_phone_msg = "";
	$secondary_phone_msg = "";
	$preferred_contact_msg = "";
	$fax_number_msg = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$login = trim($_POST['login']);
		$password = trim($_POST['password']);
		$confirm_password = trim($_POST['confirm_password']);
		$email = trim($_POST['email']);
		$salutations = trim($_POST['salutations']);
		$first_name = trim($_POST['first_name']);
		$last_name = trim($_POST['last_name']);
		$address1 = trim($_POST['address1']);
		$address2 = trim($_POST['address2']);
		$city = trim($_POST['city']);
		$provinces = trim($_POST['provinces']);
		$postal_code = trim($_POST['postal_code']);
		$primary_phone = trim($_POST['primary_phone']);
		$secondary_phone = trim($_POST['secondary_phone']);
		$fax_number = trim($_POST['fax_number']);
		$error = false;
		echo $is_agent;
		// Preferred contact method
		if (isset($_POST['preferred_contact_method'])) { $preferred_contact_method = trim($_POST['preferred_contact_method']); }
		else { $preferred_contact_msg = "Please select your preferred contact method"; $error = true; }
		
		if (isset($_POST['is_agent'])) { $is_agent = true; } else { $is_agent = false; }

		// Login ID
		if (strlen($login) == 0) { $login_msg = "Please enter login ID"; $error = true; }
		else if (strlen($login) < MINIMUM_ID_LENGTH) 
		{ 
			$login_msg = "Login ID must be at least " . MINIMUM_ID_LENGTH . " characters, " . $login . " is not long enough"; 
			$login = ""; $error = true;
		}
		else if (strlen($login) > MAXIMUM_ID_LENGTH)
		{
			$login_msg = "A user id must be less than " . MAXIMUM_ID_LENGTH . " characters long"; 
			$login = ""; $error = true;
		}
		else if (is_user_id($login))
		{
			$login_msg = "The user id <i>" . $login . "</i> already exists in our system. Please try another one."; 
			$login = ""; $error = true;
		}

		// Password
		if (strcmp($password, $confirm_password) <> 0) { $pass_msg = "The password and the confirm password were not the same"; $error = true; }
		else if (strlen($password) == 0) { $pass_msg = "Please enter your password"; $error = true; }
		else if (strlen($password) < MINIMUM_PASSWORD_LENGTH) { $pass_msg = "Your password must be at least " . MINIMUM_PASSWORD_LENGTH . " characters long"; $error = true; }
		else if (strlen($password) > MAXIMUM_PASSWORD_LENGTH) { $pass_msg = "Your password cannot be more than " . MAXIMUM_PASSWORD_LENGTH . " characters long"; $error = true; }

		// Email
		if (strlen($email) == 0) { $email_msg = "Please enter your email address"; $error = true; }
		else if (strlen($email) > MAX_EMAIL_LENGTH) { $email_msg = "Your email address cannot be more than " . MAX_EMAIL_LENGTH . " characters long"; $email = ""; $error = true; }
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$email_msg = "The email address <i>" . $email . "</i> is not valid. Please try again.";
			$email = ""; $error = true;
		}

		// First Name
		if (strlen($first_name) == 0) { $first_name_msg = "Please enter your first name"; $error = true; }
		else if (strlen($first_name) > MAX_FIRST_NAME_LENGTH) 
		{
			$first_name_msg = "Your first name needs to be less than " . MAX_FIRST_NAME_LENGTH . " characters long";
			$first_name = ""; $error = true;
		}
		else if (is_numeric($first_name)) 
		{
			$first_name_msg = "Your first name cannot be a number, you entered: " . $first_name;
			$first_name = ""; $error = true;
		}

		// Last Name
		if (strlen($last_name) == 0) { $last_name_msg = "Please enter your last name"; $error = true; }
		else if (strlen($last_name) > MAX_LAST_NAME_LENGTH) 
		{
			$last_name_msg = "Your last name needs to be less than " . MAX_LAST_NAME_LENGTH . " characters long";
			$last_name = ""; $error = true;
		}
		else if (is_numeric($last_name)) 
		{
			$last_name_msg = "Your last name cannot be a number, you entered: " . $last_name;
			$last_name = ""; $error = true;
		}

		// City
		if (strlen($city) > MAX_CITY_LENGTH) 
		{
			$city_msg = "The city needs to be less than " . MAX_CITY_LENGTH . " characters long";
			$city = ""; $error = true;
		}
		else if (is_numeric($city)) 
		{
			$city_msg = "The city cannot be a number, you entered: " . $city;
			$city = ""; $error = true;
		}

		// Street Address 1
		if (strlen($address1) > MAX_ADDRESS_LENGTH)
		{
			$address1_msg = "Your street addess 1 needs to be less than " . MAX_LAST_NAME_LENGTH . " characters long";
			$address1 = ""; $error = true;
		}

		// Street Address 2
		if (strlen($address2) > MAX_ADDRESS_LENGTH)
		{
			$address2_msg = "Your street addess 2 needs to be less than " . MAX_LAST_NAME_LENGTH . " characters long";
			$address2 = ""; $error = true;
		}

		// Postal Code
		if (strlen($postal_code) > 0)
		{
			$postal_code = strtoupper(str_replace(" ", "", $postal_code));
			if (strlen($postal_code) <> POSTAL_CODE_LENGTH)
			{
				$postal_code_msg = "The postal code must be " . POSTAL_CODE_LENGTH . " characters long";
				$postal_code = ""; $error = true;
			}
			else if (!is_valid_postal_code($postal_code))
			{
				$postal_code_msg = "The postal code you entered is not valid. Please try again.";
				$postal_code = ""; $error = true;
			}
		}

		// Primary phone number
		$clean_primary_number = str_replace(array("-", "(", ")"), array("", "", ""), $primary_phone);
		if (strlen($primary_phone) == 0) { $primary_phone_msg = "Please enter your primary phone number"; $error = true; }
		else if (strlen($clean_primary_number) <> PHONE_NUMBER_LENGTH)
		{
			$primary_phone_msg = "The phone number must be " . PHONE_NUMBER_LENGTH . " characters long";
			$primary_phone = ""; $error = true;
		}
		else if (!is_valid_phone_number($clean_primary_number))
		{
			$primary_phone_msg = "The phone number you entered is not valid. Please try again.";
			$primary_phone = ""; $error = true;
		}
		else { $primary_phone = display_phone_number($clean_primary_number); }

		// Secondary phone number
		$clean_secondary_number = str_replace(array("-", "(", ")"), array("", "", ""), $secondary_phone);
		if (strlen($secondary_phone) > 0)
		{
			if (strlen($clean_secondary_number) <> PHONE_NUMBER_LENGTH)
			{
				$secondary_phone_msg = "The phone number must be " . PHONE_NUMBER_LENGTH . " characters long";
				$secondary_phone = ""; $error = true;
			}
			else if (!is_valid_phone_number($clean_secondary_number))
			{
				$secondary_phone_msg = "The phone number you entered is not valid. Please try again.";
				$secondary_phone = ""; $error = true;
			}
			else { $secondary_phone = display_phone_number($clean_secondary_number); }
		}

		// Fax number
		$clean_fax_number = str_replace(array("-", "(", ")"), array("", "", ""), $fax_number);
		if (strlen($fax_number) > 0)
		{
			if (strlen($clean_fax_number) <> PHONE_NUMBER_LENGTH)
			{
				$fax_number_msg = "The fax number must be " . PHONE_NUMBER_LENGTH . " characters long";
				$fax_number = ""; $error = true;
			}
			else if (!is_valid_phone_number($clean_fax_number))
			{
				$fax_number_msg = "The fax number you entered is not valid. Please try again.";
				$fax_number = ""; $error = true;
			}
			else { $fax_number = display_phone_number($clean_fax_number); }
		}

		if (!$error)
		{
			$today = date("Y-m-d", time());
			if ($is_agent)
			{
				insert_into_users(array($login, hash(HASH_TYPE, $password), $email, PENDING, $today, $today));
				$_SESSION['register_msg'] = "You successfully registered into the system. Wait for your account to be approved.";
			}
			else 
			{
				insert_into_users(array($login, hash(HASH_TYPE, $password), $email, CLIENT, $today, $today));
				$_SESSION['register_msg'] = "You successfully registered into the system.";
			}
			insert_into_persons(array($login, $salutations, $first_name, $last_name, $address1, $address2, $city, $provinces, $postal_code, $clean_primary_number,
									  $clean_secondary_number, $clean_fax_number, $preferred_contact_method));
			redirect("login.php");
		}
	}
?>
<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Login Information</p>
		<div class="form-group">
			<label class="pull-left">Login ID:</label>
			<input class="form-control mb-4" type="text" name="login" value="<?php echo $login ?>" placeholder="Login ID"/>
			<?php fields_warning_message($login_msg) ?>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">Password:</label>
				<input class="form-control mb-4" id="defaultLoginFormPassword" type="password" name="password" value="" placeholder="Password"/>
				<?php fields_warning_message($pass_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Confirm Password:</label>
				<input class="form-control mb-4" id="defaultLoginConfirmPassword" type="password" name="confirm_password" value="" placeholder="Confirm Password"/>
				<?php fields_warning_message($confirm_pass_msg) ?>
			</div>
		</div>
		<div class="form-group">
			<label class="pull-left">Email Address:</label>
			<input class="form-control mb-4" type="text" name="email" value = "<?php echo $email ?>" placeholder="Email"/>
			<?php fields_warning_message($email_msg) ?>
		</div>
		<hr class="w-100"/>
		<p class="h4 mb-4">Personal Information</p>
		<div class="form-group">
			<label class="pull-left">Salutation:</label>
			<?php build_simple_dropdown(SALUTATIONS_TABLE, $salutations) ?>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">First Name:</label>
				<input class="form-control mb-4 col" type="text" name="first_name" value="<?php echo $first_name ?>" placeholder="First Name"/>
				<?php fields_warning_message($first_name_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Last Name:</label>
				<input class="form-control mb-4 col" type="text" name="last_name" value="<?php echo $last_name ?>" placeholder="Last Name"/>
				<?php fields_warning_message($last_name_msg) ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">Street Address 1:</label>
				<input class="form-control mb-4" type="text" name="address1" value="<?php echo $address1 ?>" placeholder="Street Address 1"/>
				<?php fields_warning_message($address1_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Street Address 2:</label>
				<input class="form-control mb-4" type="text" name="address2" value="<?php echo $address2 ?>" placeholder="Street Address 2"/>
				<?php fields_warning_message($address2_msg) ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">City:</label>
				<input class="form-control mb-4" type="text" name="city" value="<?php echo $city ?>" placeholder="City"/>
				<?php fields_warning_message($city_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Province:</label>
				<?php build_simple_dropdown(PROVINCES_TABLE, $provinces) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Postal Code:</label>
				<input class="form-control mb-4" type="text" name="postal_code" value="<?php echo $postal_code ?>" placeholder="A1A 1A1"/>
				<?php fields_warning_message($postal_code_msg) ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">Primary Phone Number:</label>
				<input class="form-control mb-4 col" type="text" name="primary_phone" value="<?php echo $primary_phone ?>" placeholder=""/>
				<?php fields_warning_message($primary_phone_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Secondary Phone Number:</label>
				<input class="form-control mb-4 col" type="text" name="secondary_phone" value="<?php echo $secondary_phone ?>" placeholder=""/>
				<?php fields_warning_message($secondary_phone_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Fax Number:</label>
				<input class="form-control mb-4 col" type="text" name="fax_number" value="<?php echo $fax_number ?>" placeholder=""/>
				<?php fields_warning_message($fax_number_msg) ?>
			</div>
		</div>
		<div class="form-group">
			<label class="pull-left">Preferred Contact Method:&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<?php build_radio(PREFERRED_CONTACT_TABLE, $preferred_contact_method) ?>
			<?php echo "&nbsp;&nbsp;&nbsp;"; fields_warning_message($preferred_contact_msg) ?>
		</div>
		<div class="form-group">
			<label class="pull-left">Are you an agent?&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<?php 
				$checked = "";
				if ($is_agent) { $checked = "checked"; }
			?>
			<label class='checkbox pull-left'><input type='checkbox' name='is_agent' value='agent' <?php echo $checked; ?> /></label>
		</div>
		<p><button class="btn btn-info btn-block my-4" type="submit" value="Register">Register</button></p>
	</form>
</div>
<?php include 'footer.php'; ?>