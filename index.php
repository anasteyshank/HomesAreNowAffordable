<?php 
	/*
		Group 18
		WEBD3201
		September 13, 2019
	*/
	$title = "Home Page";
	$file = "index.php";
	$description = "This is a home page of a web site created for WEBD3201";
	$date = "September 13, 2019";
  $banner = "Home Page";
  
  require 'header.php';
?>

<div class="container">
    <?php 
      if (isset($_SESSION['warning_msg']))
      {
        echo "<div class='alert alert-warning alert-dismissible fade show text-left'>
                <strong>Warning! </strong>" . $_SESSION['warning_msg'] . 
                "<button type='button' class='close' data-dismiss='alert'>&times;</button>
              </div>";
        unset($_SESSION['warning_msg']);
      }
    ?>
	  <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About</h2>
	  <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fa fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
    </div>
	  <div>
    <p class="text-center">Welcome to your future home! If you are looking for an affordable, captivating home,
                               you have come to the right place. We offer a huger variety in real estate properties
                               in the Durham Region, in which you can find exactly what kind of household you are looking for!
                               Selling your house? We can do that too! With our trusted realtors, you can both sell your
                               property or buy a new one with trusted expertise!</p> <br/><br/>

    <p class="text-center">*This is a fictional page, created for the course of Web Development (<a href="http://opentech.durhamcollege.org/pufferd/webd3201"> WEBD3201 </a> ) at <a href="https://durhamcollege.ca"> Durham College </a> - Oshawa, ON, Canada
                               All functionalities were made to satisfy the course's project and are not intended to be real, although it mimics a real estate website.</p>
    </div>
</div>

<?php include 'footer.php'; ?>