<?php 
	/*
		Group 18
		WEBD3201
		November 13, 2019
	*/
	$title = "Select City";
	$file = "listing-select-city.php";
	$description = "This is a page for selecting a city of a web site created for WEBD3201";
	$date = "November 13, 2019";
	$banner = "Select City";

	require 'header.php';
	
	if (isset($_SESSION['listing_ids'])) {redirect('listing-search-results.php');}
	
	$city = [];
	$city_value = 0;
	$city_msg = "";

	if (isset($_SESSION['cities_selected']))
	{
		$city_value = $_SESSION['cities_selected'];
		$city = get_checked_values(CITY_TABLE, $city_value);
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_SESSION['cities_selected'])) {unset($_SESSION['cities_selected']);}
		$city = [];
		if (isset($_POST['city'])) 
		{ 
			$city[] = $_POST['city']; 
			$city_value = sum_check_box($city);

			$_SESSION['cities_selected'] = $city_value;
			setcookie("cities_selected", $city_value, time() + COOKIE_LIFESPAN);
			
			redirect('listing-search.php');
		}
		else { $city_msg = "Please select the city / list of cities clicking on the checkboxes OR 
							click on the city in the picture"; }
	}
?>

<div class="container fixed-footer">
	<br/><br/>
	<div class="row">
		<form class="col-6 text-center border border-light" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			<p class="h4 mb-4">Select the city:</p>
			<?php 
				$checked = "";
				if (isset($_SESSION['cities_selected']) && $_SESSION['cities_selected'] == 127) { $checked = "checked"; }
			?>
			<p><label class='checkbox'><input type="checkbox" onclick="toggle(this);" name="select_all" value="Select All" <?php echo $checked; ?>/>Select All</label></p>
			<div class="form-group">
				<?php build_checkbox(CITY_TABLE, $city) ?>
			</div>
			<?php fields_warning_message($city_msg) ?>
			<p><button class="btn btn-info btn-block my-4" type="submit" value="Submit">Submit</button></p>
		</form>

		<div class="col-6 col-md-4 text-right">
			<img src="images/DurhamRegion_Map.PNG" alt="Durham Region Map" class="map" usemap="#drmap"/>
			<map name="drmap" id="drmap">
				<area href="listing-search.php?city=1" title="Ajax" alt="Ajax" shape="rect" coords="120,480,190,500"/>
				<area href="listing-search.php?city=2" title="Brooklin" alt="Brooklin" shape="rect" coords="200,280,270,300"/>
				<area href="listing-search.php?city=4" title="Bowmanville" alt="Bowmanville" shape="rect" coords="560,370,630,390"/>
				<area href="listing-search.php?city=8" title="Oshawa" alt="Oshawa" shape="rect" coords="325,400,395,420"/>
				<area href="listing-search.php?city=16" title="Pickering" alt="Pickering" shape="rect" coords="30,510,100,530"/>
				<area href="listing-search.php?city=32" title="Port Perry" alt="Port Perry" shape="rect" coords="225,20,295,40"/>
				<area href="listing-search.php?city=64" title="Whitby" alt="Whitby" shape="rect" coords="225,400,295,420"/>
			</map>
		</div>
	</div>
	<br/><br/>
</div>

<script type="text/javascript">
	function toggle(source) {
		checkboxes = document.getElementsByName('city[]');
		for(i = 0; i < checkboxes.length; i++)
		{
			checkboxes[i].checked = source.checked;
		}
	}
</script>

<?php include 'footer.php'; ?>