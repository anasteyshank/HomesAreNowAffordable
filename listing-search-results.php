<?php 
	/*
		Group 18
		WEBD3201
		September 24, 2019
	*/
	$title = "Search Results";
	$file = "listing-search-results.php";
	$description = "This is a page for showing a preview of multiple listings of a web site created for WEBD3201";
	$date = "September 24, 2019";
    $banner = "Search Results";
    
    require 'header.php';

    $listings_ids = [];
    
    if (isset($_SESSION["listing_ids"])) { $listings_ids = $_SESSION["listing_ids"]; }
    else { redirect('listing-search.php'); }

    $listings_checked = [];
    for ($i = 0; $i < count($listings_ids); $i++)
    {
        $listing = get_one_listing($listings_ids[$i]['listing_id']);
        if ($listing['status'] != STATUS_CLOSED && $listing['status'] != STATUS_HIDDEN && $listing['status'] != STATUS_DISABLED) { array_push($listings_checked, $listings_ids[$i]); }
    }
    $listings_ids = $listings_checked;

    $num_pages = ceil(count($listings_ids) / NUM_RECORDS_PER_PAGE);
    $page_num = 1;

    if (isset($_GET['page_num'])) { $page_num = $_GET['page_num']; }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST['btnChangeCity']))
		{
            if (isset($_COOKIE['cities_selected']))
            {
                $_SESSION['cities_selected'] = $_COOKIE['cities_selected'];
                unset($_COOKIE['cities_selected']);
                setcookie('cities_selected', '', time() - 3600, '/');
            }
		    unset($_SESSION['listing_ids']);
			redirect('listing-select-city.php');
        }
        else if (isset($_POST['btnChangeCriteria']))
        {
            unset($_SESSION['listing_ids']);
            redirect('listing-search.php');
        }
    }
?>

<div class="container fixed-footer">
    <form class="text-center border border-light p-5" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <p class="h4 mb-4 text-center">Search Results</p>
        <div class="form-row">
            <div class="form-group col">
                <button class="btn btn-info btn-block my-4" type="submit" name="btnChangeCity" value="Change City">Change City</button>
            </div>
            <div class="form-group col">
                <button class="btn btn-info btn-block my-4" type="submit" name="btnChangeCriteria" value="Change Search Criteria">Change Search Criteria</button>
            </div>
        </div>
    </form>

    <?php
        build_pagination_menu($num_pages, $page_num);
        build_listing_preview($listings_ids, $page_num);
        build_pagination_menu($num_pages, $page_num);
    ?>
</div>

<?php include 'footer.php'; ?>