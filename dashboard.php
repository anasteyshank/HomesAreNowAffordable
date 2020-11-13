<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Dashboard";
	$file = "dashboard.php";
	$description = "This is a dashboard for logged in agents of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Dashboard";

	require 'header.php';

	if (isset($_SESSION['updated_profile']))
	{
		echo "<div class='container'>
				<div class='col-md-3 col-sm-3 col-xs-3'>&nbsp;</div>
				<div class='card text-center'>
					<div class='card-header'>Congratulations!</div>
					<div class='card-body'>
						<p class='card-text'>" . $_SESSION['updated_profile'] . "	
						</p>
					</div>
				</div>
			</div>";
		unset($_SESSION['updated_profile']);
	}
	else if (isset($_SESSION['warning_msg']))
	{
		echo "<div class='alert alert-warning alert-dismissible fade show text-left'>
                <strong>Warning! </strong>" . $_SESSION['warning_msg'] . 
                "<button type='button' class='close' data-dismiss='alert'>&times;</button>
              </div>";
		unset($_SESSION['warning_msg']);
	}
	set_warning_message(AGENT, "Agent", true);
	$status = STATUS_OPEN;
	$get_request = "";

	if (isset($_GET['closed'])) { $status = STATUS_CLOSED; $get_request = "&closed"; }
	else if (isset($_GET['sold'])) { $status = STATUS_SOLD; $get_request = "&sold"; }
?>

<div class="container fixed-footer">
	<?php
		if (isset($_SESSION['logged_in']))
		{
			echo "<div class='col-md-3 col-sm-3 col-xs-3'>&nbsp;</div>
			      <div class='card text-center'>
					<div class='card-header'>Welcome!</div>
					<div class='card-body'>
						<p class='card-text'>";
			welcome_message();
			echo			"</p>
						</div>
					</div>";
			unset($_SESSION['logged_in']);
		}
	?>
	<br/>
	<p class="h4 mb-4 text-center">Manage your listings</p>
	<hr/>
	<p class="font-weight-bold">Listings Type:</p>
	<div class="row">
		<div class="col d-flex justify-content-center"><a class="btn btn-primary btn-block" href="dashboard.php" role="button">Open</a></div>
		<div class="col d-flex justify-content-center"><a class="btn btn-primary btn-block" href="dashboard.php?closed" role="button">Closed</a></div>
		<div class="col d-flex justify-content-center"><a class="btn btn-primary btn-block" href="dashboard.php?sold" role="button">Sold</a></div>
	</div>
	<br/>
	<?php
		$listings = get_agent_listings($_SESSION['user']['user_id'], $status);
		if (empty($listings) && empty($_GET)) { echo "<p>You don't have any open listings.</p>"; }
		else if (empty($listings) && isset($_GET['closed'])) { echo "<p>You don't have any closed listings.</p>"; }
		else if (empty($listings) && isset($_GET['sold'])) { echo "<p>You don't have any sold listings.</p>"; }
		else
		{
			$num_pages = ceil(count($listings) / NUM_RECORDS_PER_PAGE);
			$page_num = 1;
			if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
			build_pagination_menu($num_pages, $page_num, $get_request);
			build_listing_preview($listings, $page_num);
			build_pagination_menu($num_pages, $page_num, $get_request);
		}
	?>
</div>

<?php include 'footer.php'; ?>