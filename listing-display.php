<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Display Listings";
	$file = "listing-display.php";
	$description = "This is a page for viewing a specific listing from the results of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Display Listings";

	require 'header.php';

	if (isset($_SESSION['create_listing_msg']))
	{
		echo "<div class='container'>
				<div class='col-md-3 col-sm-3 col-xs-3'>&nbsp;</div>
				<div class='card text-center'>
					<div class='card-header'>Congratulations!</div>
					<div class='card-body'>
						<p class='card-text'>" . $_SESSION['create_listing_msg'] . "	
						</p>
					</div>
				</div>
			</div>";
		unset($_SESSION['create_listing_msg']);
	}

	$listing_info = [];

	if (isset($_GET['listing_id']))
	{
		$listing_info = get_one_listing($_GET['listing_id']);
	}
	else { redirect('listing-select-city.php'); }
	
	if ($listing_info['status'] == STATUS_CLOSED && $_SESSION['user']['user_type'] != AGENT && $listing_info['user_id'] != $_SESSION['user']['user_id']) { redirect("index.php"); }
	else if ($listing_info['status'] == STATUS_HIDDEN && $_SESSION['user']['user_type'] != ADMIN) { redirect("index.php"); }

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{ 
		if (isset($_POST['btnUpdate'])) { redirect('listing-update.php?listing_id='.$_GET['listing_id']); }
		else if (isset($_POST['btnHide']))
		{
			hide_listing($listing_info['listing_id']);
			remove_from_favourites("", $listing_info['listing_id']);
			disable_user($listing_info['user_id'], DISABLED_AGENT);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
		else if (isset($_POST['btnFavourite']))
		{
			add_to_favourites($_SESSION['user']['user_id'], $listing_info['listing_id']);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
		else if (isset($_POST['btnRemoveFavourite']))
		{
			remove_from_favourites($_SESSION['user']['user_id'], $listing_info['listing_id']);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
		else if (isset($_POST['btnReport']))
		{
			report_listing($_SESSION['user']['user_id'], $listing_info['listing_id']);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
		else if (isset($_POST['btnDisable']))
		{
			disable_listing($listing_info['listing_id']);
			remove_from_favourites("", $listing_info['listing_id']);
			close_offensives($listing_info['listing_id']);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
		else if (isset($_POST['btnDisableUser']))
		{
			disable_user($_POST['btnDisableUser']);
			remove_from_favourites($_POST['btnDisableUser']);
			close_offensives($_POST['btnDisableUser'], false);
			redirect($_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id']);
		}
	}
?>

<div class="container fixed-footer">
	<?php 
		if (isset($_SESSION['only_listing']))
		{
			echo "<div class='alert alert-warning alert-dismissible fade show text-left'>" . $_SESSION['only_listing'] . 
					"<button type='button' class='close' data-dismiss='alert'>&times;</button>
				</div>";
			unset($_SESSION['only_listing']);
		}
		if ($listing_info['images'] == 0) { echo "<img class = 'listing' src='images/No_image_available.png' alt='House Image'/>"; }
		else 
		{ 
			$default_path = "";
			$path = "images/" . $listing_info['listing_id'] . "/";
			foreach (scandir($path) as $file)
			{
				if (strlen($file) > 4) { if (!is_numeric(substr(basename($path . $file, EXT), -1))) { $default_path = $path . $file; break; } }
			}
			if ($listing_info['images'] == 1) { echo "<img class = 'listing' src='" . $default_path . "' alt='House Image'/>"; }
			else
			{
				echo "<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
						<div class='carousel-inner'>
							<div class='carousel-item active'>
								<img class='listing' src='" . $default_path . "' alt='House Image' />
							</div>";
				foreach (scandir($path) as $file)
				{
					if ($path . $file != $default_path && strlen($file) > 4) 
					{
						echo "<div class='carousel-item'>
								<img class='listing' src='" . $path . $file . "' alt='House Image' />
							</div>";
					}
				}
				echo "</div>
						<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
						<span class='carousel-control-prev-icon' aria-hidden='true'></span>
						<span class='sr-only'>Previous</span>
						</a>
						<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
						<span class='carousel-control-next-icon' aria-hidden='true'></span>
						<span class='sr-only'>Next</span>
						</a>
					</div>";
			}
		}
	?>
	
	<div class="card">
		<div class="card-body">
			<h5 class="card-title text-center"><?php echo $listing_info['headline']; ?></h5>
			<h3><?php echo "$" . number_format($listing_info['price'],2); ?></h3>
			<div class = "row">
				<p class="col"><?php echo get_property(CITY_TABLE, $listing_info['city']) . ", " .  format_postal_code($listing_info['postal_code']); ?></p>
				<p class="font-weight-bold"><?php echo get_property(BEDROOMS_TABLE, $listing_info['bedrooms']); ?>&nbsp;&nbsp;</p>
				<figure>
					<img class="icon" src="images/bed.png" alt=""/>
					<figcaption class="figure-caption text-left">Bedrooms</figcaption>
				</figure>
				<p class="font-weight-bold">&nbsp;&nbsp;<?php echo get_property(BATHROOMS_TABLE, $listing_info['bathrooms']); ?>&nbsp;&nbsp;</p>
				<figure>
					<img class="icon" src="images/bath.png" alt=""/>
					<figcaption class="figure-caption text-left">Bathrooms</figcaption>
				</figure>
			</div>	
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<p class="h4 mb-4">Description</p>
			<p><?php echo $listing_info['description']; ?></p>
			<hr/>
			<p class="h4 mb-4">Property Summary</p>
			<div class="row">
				<div class="col">
					<p class="font-weight-bold">Building Type</p>
					<p><?php echo get_property(BUILDING_TABLE, $listing_info['building_type']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Transaction Type</p>
					<p><?php echo get_property(TRANSACTION_TYPE_TABLE, $listing_info['transaction_type']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Basement Type</p>
					<p><?php echo get_property(BASEMENT_TABLE, $listing_info['basement_type']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Parking</p>
					<p><?php echo get_property(PARKING_TABLE, $listing_info['parking']); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p class="font-weight-bold">Housing Style</p>
					<p><?php echo get_property(HOUSING_TYPE_TABLE, $listing_info['housing_style']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Flooring</p>
					<p><?php echo get_property(FLOORING_TABLE, $listing_info['flooring']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Property Options</p>
					<p><?php echo get_properties_list($listing_info['property_options']); ?></p>
				</div>
				<div class="col">
					<p class="font-weight-bold">Status</p>
					<p><?php echo get_property(LISTING_STATUS_TABLE, $listing_info['status']); ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php 
		if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == AGENT && $listing_info['user_id'] == $_SESSION['user']['user_id'] && $listing_info['status'] != STATUS_DISABLED)
		{
			echo "<form class='text-center border border-light p-5' method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnUpdate' type='submit' value='Update Listing'>Update Listing</button>
				   </form>";
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == ADMIN && $listing_info['status'] != STATUS_HIDDEN)
		{
			echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnHide' type='submit' value='Hide Listing'>Hide Listing</button>
				   </form>";
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == ADMIN && $listing_info['status'] == STATUS_HIDDEN)
		{
			echo "<div class='alert alert-danger' role='alert'>
					This listing is hidden!
				</div>";
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == CLIENT && !is_in_favourites($_SESSION['user']['user_id'], $listing_info['listing_id']))
		{
			echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnFavourite' type='submit' value='Add To Favourites'>Add To Favourites</button>
				   </form>";
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == CLIENT && is_in_favourites($_SESSION['user']['user_id'], $listing_info['listing_id']))
		{
			echo "<div class='alert alert-success' role='alert'>
					This listing is in your favourites!
				</div>";
			echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnRemoveFavourite' type='submit' value='Remove'>Remove From Favourites</button>
				   </form>";
		}
		if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == CLIENT && !has_reported_listing($_SESSION['user']['user_id'], $listing_info['listing_id']))
		{
			echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnReport' type='submit' value='Report'>Report the Listing</button>
				   </form>";
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == CLIENT && has_reported_listing($_SESSION['user']['user_id'], $listing_info['listing_id']))
		{
			echo "<div class='alert alert-danger' role='alert'>
					You've reported this listing!
				</div>";
		}
		if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == ADMIN && is_in_offensives($listing_info['listing_id']) && $listing_info['status'] != STATUS_DISABLED)
		{
			echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
					<button class='btn btn-info btn-block my-4' name='btnDisable' type='submit' value='Disable Listing'>Disable Listing</button>
				   </form>";
			
			$offensives = get_offensives(OFFENSIVE_OPEN);
			if (!empty($offensives))
			{
				foreach ($offensives as $listing)
				{
					if ($listing['listing_id'] == $listing_info['listing_id'])
					{
						$user = pg_fetch_assoc(get_user_personal_information($listing['user_id']));
						echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?listing_id=' . $listing_info['listing_id'] . ">
								<div class='card'>
									<h5 class='card-header'>Reported By</h5>
									<div class='card-body'>
										<div class = 'row'>
											<p class='font-weight-bold col-sm-1 text-right'>User ID:</p>
											<p class='col'>" . $user['user_id'] . "</p>
										</div>
										<div class = 'row'>
											<p class='font-weight-bold col-sm-1 text-right'>First Name:</p>
											<p class='col'>" . $user['first_name'] . "</p>
										</div>
										<div class = 'row'>
											<p class='font-weight-bold col-sm-1 text-right'>Last Name:</p>
											<p class='col'>" . $user['last_name'] . "</p>
											<button class='btn btn-info btn-block my-4' name='btnDisableUser' type='submit' value='" . $user['user_id'] . "'>Disable User</button>
										</div> 
									</div>
								</div>
							</form><br/>";
					}
				}
			}
		}
		else if (isset($_SESSION['user']['user_type']) && $_SESSION['user']['user_type'] == ADMIN && is_in_offensives($listing_info['listing_id']) && $listing_info['status'] == STATUS_DISABLED)
		{
			echo "<div class='alert alert-danger' role='alert'>
					The listing is disabled!
				</div>";
		}
	?>
</div>

<?php include 'footer.php'; ?>