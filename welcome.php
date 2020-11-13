<?php 
	/*
		Group 18
		WEBD3201
		September 13, 2019
	*/
	$title = "Welcome";
	$file = "welcome.php";
	$description = "This is a welcome page for logged in clients of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Welcome";

	require 'header.php';
	set_warning_message(CLIENT, "Client", true);

	$favourites = get_favourites_list($_SESSION['user']['user_id']);

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if (isset($_POST['btnRemoveFavourite']))
		{
			remove_from_favourites($_SESSION['user']['user_id'], $_POST['btnRemoveFavourite']);
			$get = "";
			if (isset($_GET['page_num'])) { $get = "?page_num=" . $_GET['page_num']; }
			redirect($_SERVER['PHP_SELF'] . $get);
		}
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
	<p class="h4 mb-4 text-center">Favourites</p>
	<hr/>
	<?php
		if (empty($favourites)) { echo "<p>You haven't added anything to your favourites list yet.</p>"; }
		else
		{
			$num_pages = ceil(count($favourites) / NUM_RECORDS_PER_PAGE);
			$page_num = 1;
			if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
			build_pagination_menu($num_pages, $page_num);
			build_favourites_preview($favourites, $page_num);
			build_pagination_menu($num_pages, $page_num);
		}
	?>
</div>

<?php include 'footer.php'; ?>

