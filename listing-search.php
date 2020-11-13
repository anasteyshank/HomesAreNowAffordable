<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Search Listings";
	$file = "listing-search.php";
	$description = "This is a page for searching listings of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Search Listings";

	require 'header.php';

	$cities = [];
	$cities_string = "";

	$min_price = "";
	$max_price = "";
	$bedrooms = [];
	$bathrooms = [];
	$housing_style = "";
	$flooring = "";
	$building_type = "";
	$transaction_type = "";
	$basement_type = "";
	$parking = "";
	$properties = [];

	$min_price_msg = "";
	$max_price_msg = "";
	$bedrooms_msg = "";
	$bathrooms_msg = "";
	$housing_style_msg = "";
	$flooring_msg = "";
	$building_type_msg = "";
	$transaction_type_msg = "";
	$basement_type_msg = "";
	$parking_msg = "";
	$error_msg = "";

	if (isset($_SESSION['listing_ids'])) { redirect('listing-search-results.php'); }

	if (isset($_GET['city']))
	{
		setcookie("cities_selected", $_GET['city'], time() + COOKIE_LIFESPAN);
		$cities = get_checked_values(CITY_TABLE, $_GET['city']);
		$cities_string = $cities[0];
	}
	else if (isset($_COOKIE['cities_selected']))
	{
		$cities = get_checked_values(CITY_TABLE, $_COOKIE['cities_selected']);
		foreach ($cities as $value) { $cities_string .= $value; $cities_string .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
	}
	else { redirect('listing-select-city.php'); }

	if (($_SERVER["REQUEST_METHOD"] == "GET"))
	{
		if (isset($_COOKIE['MIN_PRICE'])) {$min_price = $_COOKIE['MIN_PRICE'];}
		if (isset($_COOKIE['MAX_PRICE'])) {$max_price = $_COOKIE['MAX_PRICE'];}
		if (isset($_COOKIE['BEDROOMS'])) {$bedrooms = get_checked_values(BEDROOMS_TABLE, $_COOKIE['BEDROOMS']);}
		if (isset($_COOKIE['BATHROOMS'])) {$bathrooms = get_checked_values(BATHROOMS_TABLE, $_COOKIE['BATHROOMS']);}
		if (isset($_COOKIE['HOUSING_STYLE'])) {$housing_style = get_property(HOUSING_TYPE_TABLE, $_COOKIE['HOUSING_STYLE']);}
		if (isset($_COOKIE['FLOORING'])) {$flooring = get_property(FLOORING_TABLE, $_COOKIE['FLOORING']);}
		if (isset($_COOKIE['BUILDING_TYPE'])) {$building_type = get_property(BUILDING_TABLE, $_COOKIE['BUILDING_TYPE']);}
		if (isset($_COOKIE['TRANSACTION_TYPE'])) {$transaction_type = get_property(TRANSACTION_TYPE_TABLE, $_COOKIE['TRANSACTION_TYPE']);}
		if (isset($_COOKIE['BASEMENT_TYPE'])) {$basement_type = get_property(BASEMENT_TABLE,$_COOKIE['BASEMENT_TYPE']);}
		if (isset($_COOKIE['PARKING'])) {$parking = get_property(PARKING_TABLE, $_COOKIE['PARKING']);}
		if (isset($_COOKIE['PROPERTY_OPTIONS'])) {$properties = get_checked_values(PROPERTY_OPTIONS_TABLE, $_COOKIE['PROPERTY_OPTIONS']);}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST['btnChangeCities']))
		{
			$_SESSION['cities_selected'] = $_COOKIE['cities_selected'];
			unset($_COOKIE['cities_selected']);
			setcookie('cities_selected', '', time() - 3600, '/');
			redirect('listing-select-city.php');
		}
		else if (isset($_POST['btnSearch']))
		{
			$min_price = trim($_POST['min_price']);
			$max_price = trim($_POST['max_price']);
			if (isset($_POST['bedrooms'])) {$bedrooms[] = $_POST['bedrooms']; }
			if (isset($_POST['bathrooms'])) {$bathrooms[] = $_POST['bathrooms']; }
			if (isset($_POST['property_options'])) {$properties[] = $_POST['property_options'];}
			$housing_style = trim($_POST['housing_style']);
			$flooring = trim($_POST['flooring']);
			$building_type = trim($_POST['building_type']);
			$transaction_type = trim($_POST['transaction_type']);
			$basement_type = trim($_POST['basement_type']);
			$parking = trim($_POST['parking']);
			$error = false;

			
			if (strlen($min_price) <> 0 && !is_numeric($min_price)) { $min_price_msg = "Please enter a valid number for the minimum price"; $error = true; $min_price=""; }
			else if (strlen($min_price) <> 0 && $min_price <= 0) { $min_price_msg = "Please enter a positive number for the minimum price"; $error = true; $min_price=""; }

			if (strlen($max_price) <> 0 && !is_numeric($max_price)) { $max_price_msg = "Please enter a valid number for the maximum price"; $error = true; $max_price=""; }
			else if (strlen($max_price) <> 0 && $max_price <= 0) { $max_price_msg = "Please enter a positive number for the maximum price"; $error = true; $max_price=""; }
			
			if (!$error && strlen($min_price) <> 0 && strlen($max_price) <> 0)
			{
				if ($min_price > $max_price)
				{
					$price = $max_price;
					$max_price = $min_price;
					$min_price = $price;
				}
			}

			if (!$error)
			{
				set_listing_search_cookies($min_price, $max_price, $bedrooms, $bathrooms, $housing_style, $flooring, $properties, $building_type, $transaction_type, $basement_type, $parking);
				$listings = get_listings_list($cities, $bedrooms, $bathrooms, $properties, $housing_style, $flooring, $building_type, $transaction_type, $basement_type, $parking, $min_price, $max_price);
				if (pg_num_rows($listings) == 0)
				{
					$error_msg = "There are no matches found. Please try to expand your search criteria.";
				}
				else if (pg_num_rows($listings) == 1)
				{
					$_SESSION['only_listing'] = "This is the only match we found with the specified search criteria.";
					redirect("listing-display.php?listing_id=".pg_fetch_row($listings)[0]);
				}
				else
				{
					$_SESSION["listing_ids"] = pg_fetch_all($listings);
					redirect('listing-search-results.php');
				}
			}
		}
	}
?>

<div class="container fixed-footer">
	<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<p class="h4 mb-4">Search for a listing</p>
		<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<div class="form-group">
				<label class="pull-left font-weight-bold">Selected Cities:</label>
				<label class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cities_string; ?></label>
				<button class="btn btn-info pull-right" type="submit" name="btnChangeCities" value="Change Location">Change Location</button>
			</div>
		</form>
		<hr/>
		<?php fields_warning_message($error_msg) ?>
		<form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<div class="form-row">
				<div class="form-group col">
					<label class="pull-left">Minimum Price:</label>
					<input class="form-control mb-4" type="text" name="min_price" value="<?php echo $min_price ?>" placeholder="Min. Price"/>
					<?php fields_warning_message($min_price_msg) ?>
				</div>
				&nbsp;&nbsp;
				<div class="form-group col">
					<label class="pull-left">Maximum Price:</label>
					<input class="form-control mb-4" type="text" name="max_price" value="<?php echo $max_price ?>" placeholder="Max. Price"/>
					<?php fields_warning_message($max_price_msg) ?>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="pull-left">Number of Bedrooms:</label>
					<br/>
					<p class="pull-left"><?php build_checkbox(BEDROOMS_TABLE, $bedrooms) ?></p>
					<?php fields_warning_message($bedrooms_msg) ?>
				</div>
				&nbsp;&nbsp;
				<div class="form-group col">
					<label class="pull-left">Number of Bathrooms:</label>
					<br/>
					<p class="pull-left"><?php build_checkbox(BATHROOMS_TABLE, $bathrooms) ?></p>
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
			<br/>
			<button class="btn btn-info btn-block my-4" type="submit" name="btnSearch" value="Search">Search</button>
		</form>
	</form>	
</div>

<?php include 'footer.php'; ?>