<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Create Listing";
	$file = "listing-create.php";
	$description = "This is a page for creating listings of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Create Listing";

	require 'header.php';
	set_warning_message(AGENT, "Agent", true);

	$headline = "";
	$listing_description = "";
	$city = "";
	$postal_code = "";
	$bedrooms = "";
	$bathrooms = "";
	$properties = [];
	$price = "";
	$listing_status = "";
	$building_type = "";
	$transaction_type = "";
	$basement_type = "";
	$parking = "";
	$housing_style = "";
	$flooring = "";
	$image = 0;
	$properties_value = 0;

	$headline_msg = "";
	$description_msg = "";
	$city_msg = "";
	$postal_code_msg = "";
	$bedrooms_msg = "";
	$bathrooms_msg = "";
	$price_msg = "";
	$status_msg = "";
	$building_type_msg = "";
	$transaction_type_msg = "";
	$basement_type_msg = "";
	$parking_msg = "";
	$housing_style_msg = "";
	$flooring_msg = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$headline = trim($_POST['headline']);
		$listing_description = trim($_POST['listing_description']);
		$city = trim($_POST['city']);
		$postal_code = trim($_POST['postal_code']);
		$bedrooms = trim($_POST['bedrooms']);
		$bathrooms = trim($_POST['bathrooms']);
		if (isset($_POST['property_options'])) {$properties[] = $_POST['property_options']; $properties_value = sum_check_box($properties); }
		$price = trim($_POST['price']);
		$listing_status = trim($_POST['listing_status']);
		$building_type = trim($_POST['building_type']);
		$transaction_type = trim($_POST['transaction_type']);
		$basement_type = trim($_POST['basement_type']);
		$parking = trim($_POST['parking']);
		$housing_style = trim($_POST['housing_style']);
		$flooring = trim($_POST['flooring']);
		$error = false;

		if (strlen($headline) == 0) { $headline_msg = "Please enter the listing's headline"; $error = true; }

		if (strlen($listing_description) == 0) { $description_msg = "Please enter the listing's description"; $error = true; }

		if (get_value(CITY_TABLE, $city) == "") { $city_msg = "Please select the city"; $error = true; }

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
		else {$postal_code_msg = "Please enter a postal code"; $error = true;}

		if (get_value(BEDROOMS_TABLE, $bedrooms) == "") { $bedrooms_msg = "Please select the number of bedrooms"; $error = true; }

		if (get_value(BATHROOMS_TABLE, $bathrooms) == "") { $bathrooms_msg = "Please select the number of bathrooms"; $error = true; }

		if (strlen($price) == 0) { $price_msg = "Please enter the price"; $error = true; }
		else if (!is_numeric($price)) { $price_msg = "Please enter a valid number for the price"; $error = true; $price = ""; }
		else if ($price < 0 || $price == "-0") { $price_msg = "Please enter a positive number for the price"; $error = true; $price = ""; }

		if (get_value(LISTING_STATUS_TABLE, $listing_status) == "") { $status_msg = "Please select the listing status"; $error = true; }

		if (get_value(BUILDING_TABLE, $building_type) == "") { $building_type_msg = "Please select the building type"; $error = true; }

		if (get_value(TRANSACTION_TYPE_TABLE, $transaction_type) == "") { $transaction_type_msg = "Please select the transaction type"; $error = true; }

		if (get_value(BASEMENT_TABLE, $basement_type) == "") { $basement_type_msg = "Please select the basement type"; $error = true; }

		if (get_value(PARKING_TABLE, $parking) == "") { $parking_msg = "Please select the parking option"; $error = true; }

		if (get_value(HOUSING_TYPE_TABLE, $housing_style) == "") { $housing_style_msg = "Please select the housing style"; $error = true; }

		if (get_value(FLOORING_TABLE, $flooring) == "") { $flooring_msg = "Please select the flooring option"; $error = true; }

		if (!$error)
		{
			insert_into_listings(array($_SESSION['user']['user_id'], get_value(LISTING_STATUS_TABLE, $listing_status), $price, $headline, $listing_description, $postal_code, $image, get_value(CITY_TABLE, $city), 
								 $properties_value, get_value(BEDROOMS_TABLE, $bedrooms), get_value(BATHROOMS_TABLE, $bathrooms), get_value(BUILDING_TABLE, $building_type), 
								 get_value(TRANSACTION_TYPE_TABLE, $transaction_type), get_value(BASEMENT_TABLE, $basement_type), get_value(PARKING_TABLE, $parking), get_value(HOUSING_TYPE_TABLE, $housing_style), 
								 get_value(FLOORING_TABLE, $flooring)));
			$_SESSION['create_listing_msg'] = "You successfully created a new listing!";
			redirect("listing-display.php?listing_id=".(get_num_records(LISTINGS_TABLE)[0]));
		}
	}
?>

<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Create New Listing</p>
		<div class="form-group">
			<label class="pull-left">Headline:</label>
			<input class="form-control mb-4" type="text" name="headline" value="<?php echo $headline ?>" placeholder="Headline"/>
			<?php fields_warning_message($headline_msg) ?>
		</div>
		<div class="form-group">
			<label class="pull-left">Description:</label>
			<textarea class="form-control input-lg" type="text" name="listing_description" value="<?php echo $listing_description ?>" placeholder="Description" rows="5"><?php echo $listing_description ?></textarea>
			<?php fields_warning_message($description_msg) ?>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label class="pull-left">City:</label>
				<?php build_dropdown(CITY_TABLE, $city) ?>
				<?php fields_warning_message($city_msg) ?>
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
				<label class="pull-left">Number of Bedrooms:</label>
				<?php build_dropdown(BEDROOMS_TABLE, $bedrooms) ?>
				<?php fields_warning_message($bedrooms_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Number of Bathrooms:</label>
				<?php build_dropdown(BATHROOMS_TABLE, $bathrooms) ?>
				<?php fields_warning_message($bathrooms_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Housing Style:</label>
				<?php build_dropdown(HOUSING_TYPE_TABLE, $housing_style) ?>
				<?php fields_warning_message($housing_style_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Flooring:</label>
				<?php build_dropdown(FLOORING_TABLE, $flooring) ?>
				<?php fields_warning_message($flooring_msg) ?>
			</div>
		</div>
		<div class="form-group">
			<label class="pull-left">Property options:&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<?php build_checkbox(PROPERTY_OPTIONS_TABLE, $properties) ?>
		</div>
		<div class="form-row">
			<div class="form-group col">	
				<label class="pull-left">Price:</label>
				<input class="form-control mb-4" type="text" name="price" value="<?php echo $price ?>" placeholder="Price"/>
				<?php fields_warning_message($price_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Status:</label>
				<?php build_dropdown(LISTING_STATUS_TABLE, $listing_status) ?>
				<?php fields_warning_message($status_msg) ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">	
				<label class="pull-left">Building Type:</label>
				<?php build_dropdown(BUILDING_TABLE, $building_type) ?>
				<?php fields_warning_message($building_type_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Transaction Type:</label>
				<?php build_dropdown(TRANSACTION_TYPE_TABLE, $transaction_type) ?>
				<?php fields_warning_message($transaction_type_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Basement Type:</label>
				<?php build_dropdown(BASEMENT_TABLE, $basement_type) ?>
				<?php fields_warning_message($basement_type_msg) ?>
			</div>
			&nbsp;&nbsp;
			<div class="form-group col">
				<label class="pull-left">Parking:</label>
				<?php build_dropdown(PARKING_TABLE, $parking) ?>
				<?php fields_warning_message($parking_msg) ?>
			</div>
		</div>
		<button class="btn btn-info btn-block my-4" type="submit" value="Create Listing">Create Listing</button>
	</form>
</div>

<?php include 'footer.php'; ?>