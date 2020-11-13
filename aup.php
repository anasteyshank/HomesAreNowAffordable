<?php 
	/*
		Group 18
		WEBD3201
		December 8, 2019
	*/
	$title = "Acceptable Use Policy";
	$file = "aup.php";
	$description = "This is a page for viewing acceptable use policy of a web site created for WEBD3201";
	$date = "December 8, 2019";
	$banner = "Acceptable Use Policy";

    require 'header.php';
?>
<div class="container fixed-footer">
	<br/>
	<?php 
      if (isset($_SESSION['disabled_user']))
      {
        echo "<div class='alert alert-warning alert-dismissible fade show text-left'>
                <strong>Warning! </strong>" . $_SESSION['disabled_user'] . 
                "<button type='button' class='close' data-dismiss='alert'>&times;</button>
              </div>";
        unset($_SESSION['disabled_user']);
      }
    ?>
	<h1 class="text-center">Acceptable Use Policy</h1>
	<p>Please read this acceptable use policy ("policy", “AUP”) carefully before using HANA website operated by HANA.</p>
	<p>Services provided by us may only be used for lawful purposes. You agree to comply with all applicable laws, rules and regulations in connection with your use of the services. Any material or conduct that in our judgment violates this policy in any manner may result in suspension or termination of the services or removal of user’s account with or without notice.</p>
	<p><strong>Prohibited use</strong></p>
	<p>You may not use the services to publish content or engage in activity that is illegal under applicable law, that is harmful to others, or that would subject us to liability, including, without limitation, in connection with any of the following, each of which is prohibited under this AUP:</p>
	<ul>
	<li>Phishing or engaging in identity theft</li>
	<li>Distributing computer viruses, worms, Trojan horses or other malicious code</li>
	<li>Distributing pornography or adult related content or offering any escort services</li>
	<li>Promoting or facilitating violence or terrorist activities</li>
	<li>Infringing the intellectual property or other proprietary rights of others</li>
	</ul>
	<p><strong>Enforcement</strong></p>
	<p>Your services may be suspended or terminated with or without notice upon any violation of this policy. Any violations may result in the immediate suspension or termination of your account.</p>
	<p><strong>Reporting violations</strong></p>
	<p>To report a violation of this policy, please contact us.</p>
	<p>We reserve the right to change this policy at any given time, of which you will be promptly updated. If you want to make sure that you are up to date with the latest changes, we advise you to frequently visit this page.</p>
</div>
<?php include 'footer.php'; ?>