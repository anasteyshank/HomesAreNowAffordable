<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Admin Page";
	$file = "admin.php";
	$description = "This is an admin page for logged in admin users of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Admin Page";

	require 'header.php';
	set_warning_message(ADMIN, "Admin", true);

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{ 
		if (isset($_POST['btnDisable'])) { disable_user($_POST['btnDisable'], DISABLED_AGENT); }
		else if (isset($_POST['btnEnable'])) { enable_user($_POST['btnEnable']); }
		
	}
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
	<p class="h4 mb-4 text-center">Manage listings and accounts</p>
	<hr/>
	<div class="row">
		<div class="col d-flex justify-content-center"><a class="btn btn-primary" href="admin.php" role="button">&nbsp;&nbsp;Pending Agents&nbsp;&nbsp;</a></div>
		<div class="col d-flex justify-content-center"><a class="btn btn-primary" href="admin.php?offensives" role="button">Offensive Listings</a></div>
	</div>
	<hr/>
	<?php
		if (!isset($_GET['offensives']))
		{
			$pending_users = pg_fetch_all(get_users(PENDING));
			if (empty($pending_users)) { echo "<p>No pending users.</p>"; }
			else 
			{
				$num_pages = ceil(count($pending_users) / NUM_RECORDS_PER_PAGE);
				$page_num = 1;
				if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
				build_pagination_menu($num_pages, $page_num);
				build_users_preview($pending_users, $page_num, "Pending", true);
				build_pagination_menu($num_pages, $page_num);
			}
		}
		else
		{
			$get_request = "&offensives";
			$listings = get_offensives(OFFENSIVE_OPEN);
			if (empty($listings)) { echo "<p>No listings have been reported.</p>"; }
			else
			{
				$num_pages = ceil(count($listings) / NUM_RECORDS_PER_PAGE);
				$page_num = 1;
				if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
				build_pagination_menu($num_pages, $page_num, $get_request);
				build_listing_preview($listings, $page_num);
				build_pagination_menu($num_pages, $page_num, $get_request);
			}
		}
	?>
</div>

<?php include 'footer.php'; ?>