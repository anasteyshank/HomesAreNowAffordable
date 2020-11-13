<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Logout";
	$file = "logout.php";
	$description = "This is an admin page for logged in admin users of a web site created for WEBD3201";
	$date = "September 24, 2019";
	$banner = "Logout";

	require 'header.php';

	if (isset($_SESSION['user']))
	{
		session_unset($_SESSION);
		session_destroy();
		session_start();
		$_SESSION["logout_msg"] = "You successfully logged out of your account!";
		redirect('login.php');
	}
	else { redirect('login.php'); }

	include 'footer.php';
?>