<?php 
	/*
		Group 18
		WEBD3201
		December 8, 2019
	*/
	$title = "View Disabled Users";
	$file = "disabled-users.php";
	$description = "This is a page for viewing disabled users of a web site created for WEBD3201";
	$date = "December 8, 2019";
	$banner = "View Disabled Users";

	require 'header.php';
	set_warning_message(ADMIN, "Admin", true);

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if (isset($_POST['btnEnable'])) 
		{
			$user = pg_fetch_assoc(get_user($_POST['btnEnable']));
			if (strlen($user['user_type']) > 1) { enable_user($_POST['btnEnable']); }
			else { enable_user($_POST['btnEnable'], CLIENT); }
		}
	}
?>

<div class="container fixed-footer">
	<br/>
	<p class="h4 mb-4 text-center">Disabled Users</p>
	<hr/>
	<?php
		$disabled_users = pg_fetch_all(get_users(DISABLED));
		$disabled_agents = pg_fetch_all(get_users(DISABLED_AGENT));

		if (empty($disabled_users) && empty($disabled_agents)) { echo "<p>No disabled users.</p>"; }
		else 
		{
			if (!is_array($disabled_users)) { $disabled_users = $disabled_agents; }
			else if (is_array($disabled_users) && is_array($disabled_agents)) { $disabled_users = array_merge($disabled_agents, $disabled_users); }
			$num_pages = ceil(count($disabled_users) / NUM_RECORDS_PER_PAGE);
			$page_num = 1;
			if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
			build_pagination_menu($num_pages, $page_num);
			build_users_preview($disabled_users, $page_num, "Disabled");
			build_pagination_menu($num_pages, $page_num);
		}
	?>
</div>

<?php include 'footer.php'; ?>