<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   		              "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<?php 
    require "includes/constants.php";
    require "includes/db.php";
    require "includes/functions.php"; 

    ob_start();

    session_start();
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/webd3201.css" />
	<title><?php echo $title; ?></title>
	<!--
		Author: Group 18
		Filename: <?php echo $file . "\n"; ?>
		Date: <?php echo $date . "\n"; ?>
		Description: <?php echo $description . "\n"; ?>
    -->
</head>

<body>
    <div class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a href="index.php"><img src="images/HANA_logo.png" alt="Web site's logo" class="logos"/></a>
            <a class="navbar-brand" href="index.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Homes are now affordable</a>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class='nav-item'>
                        <a class='nav-link' href='index.php'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='listing-select-city.php'>Listings</a>
                    </li>
                    <?php 
                        if (!isset($_SESSION['user']))
                        {
                            echo "<li class='nav-item'>
                                    <a class='nav-link' href='register.php'>Register</a>
                                  </li>
                                  <li class='nav-item'>
                                    <a class='nav-link' href='login.php'>Login</a>
                                  </li>";
                        }
                        else
                        {
                            if ($_SESSION['user']['user_type'] == AGENT)
                            {
                                echo "<li class='nav-item'>
                                        <a class='nav-link' href='dashboard.php'>Dashboard</a>
                                      </li>
                                      <li class='nav-item'>
                                        <a class='nav-link' href='listing-create.php'>Create Listing</a>
                                      </li>";
                            }
                            else if ($_SESSION['user']['user_type'] == CLIENT)
                            {
                                echo "<li class='nav-item'>
                                        <a class='nav-link' href='welcome.php'>Favourites</a>
                                      </li>";
                            }
                            else if ($_SESSION['user']['user_type'] == ADMIN)
                            {
                                echo "<li class='nav-item'>
                                        <a class='nav-link' href='admin.php'>Admin Page</a>
                                      </li>
                                      <li class='nav-item'>
                                        <a class='nav-link' href='disabled-users.php'>Disabled Users</a>
                                      </li>";
                            }
                            echo "<li class='nav-item dropdown'>
                                    <a class='nav-link dropdown-toggle' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Account
                                    </a>
                                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                    <a class='dropdown-item' href='update.php'>Update Profile</a>
                                    <a class='dropdown-item' href='change-password.php'>Change Password</a>
                                    </div>
                                  </li>
                                  <li class='nav-item'>
                                    <a class='nav-link' href='logout.php'>Logout</a>
                                  </li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php 
        if ($file == "index.php")
        {
            echo "<div id='carouselExampleSlidesOnly' class='carousel slide' data-ride='carousel'>
                    <div class='carousel-inner'>
                        <div class='carousel-item active'>
                            <img class='d-block w-100' src='./images/house_1.jpg' alt='First slide'/>
                        </div>
                        <div class='carousel-item'>
                            <img class='d-block w-100' src='./images/house_2.jpg' alt='Second slide'/>
                        </div>
                        <div class='carousel-item'>
                            <img class='d-block w-100' src='./images/house_3.jpg' alt='Third slide'/>
                        </div>
                    </div>
                </div>";
        } 
    ?>
    