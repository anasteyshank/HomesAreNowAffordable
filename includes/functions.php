<?php
	/*
		Group 18
		WEBD3201
		September 14, 2019
	*/
	function display_copyright()
	{
		echo '&copy;' . 'HANA ' . date('Y');
	}	

	function dump($arg)
	{
		echo "<pre>";
		echo (is_array($arg))? print_r($arg): $arg;
		echo "</pre>";
	}

	function redirect($file_name)
	{
		header ("location: " . $file_name);
		ob_flush();
	}

	function set_warning_message($user_type = CLIENT, $message = "Client", $check_user_type = false)
	{
		if (!isset($_SESSION['user']))
		{
			$_SESSION['warning_msg'] = "Please log in to access the requested page.";
			redirect('login.php');
		}
		else if ($_SESSION['user']['user_type'] != $user_type && $check_user_type)
		{
			$_SESSION['warning_msg'] = "You are not logged in as " . $message;
			redirect('index.php');
		}
	}

	function welcome_message()
	{
		echo "Welcome back " . $_SESSION['person']['first_name'] . " " . $_SESSION['person']['last_name'] .
			 "<br/>Our records show that your <br/>email address is: " . $_SESSION['user']['email_address'] .
			 "<br/>and you last accessed our system: " . $_SESSION['user']['last_access'];
	}

	function fields_warning_message($message)
	{
		if ($message != "")
		{
			echo "<div class='alert alert-warning alert-dismissible fade show text-left'>
					<strong>Warning! </strong>$message
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					</div>";
		}
	}

	function is_valid_postal_code($postal_code)
	{
		return (bool) preg_match(CANADIAN_POSTAL_CODE, $postal_code);
	}

	function format_postal_code($postal_code)
	{
		return substr($postal_code, 0, 3) . " " . substr($postal_code, 3, 6);
	}

	function is_valid_phone_number($phone_number)
	{
		return (bool) preg_match(CANADIAN_PHONE_NUMBER, $phone_number);
	}

	function display_phone_number($number)
	{
		return '('. substr($number, 0, 3) . ')' . substr($number, 3, 3) . '-' . substr($number, 6, 4);
	}

	function is_bit_set($power, $decimal) 
	{
		if ((pow(2, $power)) & ($decimal)) 
			return 1;
		else
			return 0;
	} 
	
	function sum_check_box($array)
	{
		$sum = 0;
		foreach ($array as $value)
		{
			if (is_array($value))
			{
				foreach ($value as $arg) { $sum += $arg; }
			}
			else { $sum += $value; }
		}
		return $sum;
	}

	function set_listing_search_cookies($min_price, $max_price, $bedrooms, $bathrooms, $housing_style, $flooring, $properties, $building_type, $transaction_type, $basement_type, $parking)
	{
		setcookie("MIN_PRICE", $min_price, time() + COOKIE_LIFESPAN);
		setcookie("MAX_PRICE", $max_price, time() + COOKIE_LIFESPAN);
		setcookie("BEDROOMS", sum_check_box($bedrooms), time() + COOKIE_LIFESPAN);
		setcookie("BATHROOMS", sum_check_box($bathrooms), time() + COOKIE_LIFESPAN);
		setcookie("HOUSING_STYLE", get_value(HOUSING_TYPE_TABLE, $housing_style), time() + COOKIE_LIFESPAN);
		setcookie("FLOORING", get_value(FLOORING_TABLE, $flooring), time() + COOKIE_LIFESPAN);
		setcookie("PROPERTY_OPTIONS", sum_check_box($properties), time() + COOKIE_LIFESPAN);
		setcookie("BUILDING_TYPE", get_value(BUILDING_TABLE, $building_type), time() + COOKIE_LIFESPAN);
		setcookie("TRANSACTION_TYPE", get_value(TRANSACTION_TYPE_TABLE, $transaction_type), time() + COOKIE_LIFESPAN);
		setcookie("BASEMENT_TYPE", get_value(BASEMENT_TABLE, $basement_type), time() + COOKIE_LIFESPAN);
		setcookie("PARKING", get_value(PARKING_TABLE, $parking), time() + COOKIE_LIFESPAN);
	}

	function get_properties_list($value)
	{
		$array = get_checked_values(PROPERTY_OPTIONS_TABLE, $value);
		$str = "<ul>";
		foreach ($array as $arg) { $str .= "<li>"; $str .= $arg; $str .= "</li>"; }
		$str .= "</ul>";
		return $str;
	}

	function build_listing_preview($listings_ids, $page_num)
	{
		$records_left = count($listings_ids) - (($page_num-1) * NUM_RECORDS_PER_PAGE);
        $num_records = 0;
        if ($records_left < NUM_RECORDS_PER_PAGE) { $num_records = $records_left; }
        else { $num_records = NUM_RECORDS_PER_PAGE; }
        
        $index = ($page_num-1) * NUM_RECORDS_PER_PAGE;
        
        for ($i = 0; $i < $num_records; $i++)
        {
            $listing = get_one_listing($listings_ids[$index]['listing_id']);
            
            echo "<div class='media position-relative rounded border'>
                    <img src='";
                    
			if ($listing['images'] == 0) { echo "images/No_image_available.png"; }
			else 
			{ 
				$path = "images/" . $listing['listing_id'] . "/";
				foreach (scandir($path) as $file)
				{
					if (strlen($file) > 4)
					{
						if (!is_numeric(substr(basename($path . $file, EXT), -1))) { echo $path . $file; $path = $path . $file; break; }
					}
				}
				if ($path == "images/" . $listing['listing_id'] . "/") { rename($path . $file, $path . $listing['listing_id'] . "_" . substr(basename($path . $file, EXT), -1) . "d" . EXT); echo $path . $listing['listing_id'] . "_" . substr(basename($path . $file, EXT), -1) . "d" . EXT;  }
			}
            
            echo "' class='mr-3 img_preview' alt='House Picture'/>
                    <div class='media-body'>
                    <h5 class='mt-0'>" . $listing['headline'] . "</h5>
                    <p>$" . number_format($listing['price'],2) . "</p>
                    <div class = 'row'>
                        <p class='col'>" . get_property(CITY_TABLE, $listing['city']) . ", " .  format_postal_code($listing['postal_code']) . "</p>
                        <p class='font-weight-bold'>" . get_property(BEDROOMS_TABLE, $listing['bedrooms']) . "&nbsp;&nbsp;</p>
                        <figure>
                            <img class='icon' src='images/bed.png' alt=''/>
                            <figcaption class='figure-caption text-left'>Bedrooms</figcaption>
                        </figure>
                        <p class='font-weight-bold'>&nbsp;&nbsp;" . get_property(BATHROOMS_TABLE, $listing['bathrooms']) . "&nbsp;&nbsp;</p>
                        <figure>
                            <img class='icon' src='images/bath.png' alt=''/>
                            <figcaption class='figure-caption text-left'>Bathrooms</figcaption>
                        </figure>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>	
                    <a href='listing-display.php?listing_id=" . $listings_ids[$index]['listing_id'] . "' class='stretched-link'></a>
                    </div>
                  </div><br/><br/>";
            $index++;
        }
	}

	function build_favourites_preview($favourites, $page_num)
	{
		$records_left = count($favourites) - (($page_num-1) * NUM_RECORDS_PER_PAGE);
        $num_records = 0;
        if ($records_left < NUM_RECORDS_PER_PAGE) { $num_records = $records_left; }
        else { $num_records = NUM_RECORDS_PER_PAGE; }
        
        $index = ($page_num-1) * NUM_RECORDS_PER_PAGE;
        $get = "";
        for ($i = 0; $i < $num_records; $i++)
        {
			if (isset($_GET['page_num'])) { $get = "?page_num=" . $_GET['page_num']; }
            $listing = get_one_listing($favourites[$index]['listing_id']);
			
            echo "<div class='media position-relative rounded border'>
					<a href='listing-display.php?listing_id=" . $favourites[$index]['listing_id'] . "'><img src='";
                    
			if ($listing['images'] == 0) { echo "images/No_image_available.png"; }
			else if ($listing['status'] == STATUS_SOLD) { echo "images/sold.jpg"; }
			else 
			{ 
				$path = "images/" . $listing['listing_id'] . "/";
				foreach (scandir($path) as $file)
				{
					if (strlen($file) > 4)
					{
						if (!is_numeric(substr(basename($path . $file, EXT), -1))) { echo $path . $file; $path = $path . $file; break; }
					}
				}
				if ($path == "images/" . $listing['listing_id'] . "/") { rename($path . $file, $path . $listing['listing_id'] . "_" . substr(basename($path . $file, EXT), -1) . "d" . EXT); echo $path . $listing['listing_id'] . "_" . substr(basename($path . $file, EXT), -1) . "d" . EXT;  }
			}
            
            echo "' class='mr-3 img_preview' alt='House Picture'/></a>
                    <div class='media-body'>
                    <h5 class='mt-0'>" . $listing['headline'] . "</h5>
                    <p>$" . number_format($listing['price'],2) . "</p>
                    <div class = 'row'>
                        <p class='col'>" . get_property(CITY_TABLE, $listing['city']) . ", " .  format_postal_code($listing['postal_code']) . "</p>
                        <p class='font-weight-bold'>" . get_property(BEDROOMS_TABLE, $listing['bedrooms']) . "&nbsp;&nbsp;</p>
                        <figure>
                            <img class='icon' src='images/bed.png' alt=''/>
                            <figcaption class='figure-caption text-left'>Bedrooms</figcaption>
                        </figure>
                        <p class='font-weight-bold'>&nbsp;&nbsp;" . get_property(BATHROOMS_TABLE, $listing['bathrooms']) . "&nbsp;&nbsp;</p>
                        <figure>
                            <img class='icon' src='images/bath.png' alt=''/>
                            <figcaption class='figure-caption text-left'>Bathrooms</figcaption>
                        </figure>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<form method='post' action=" . $_SERVER['PHP_SELF'] . $get . ">
						<button class='btn btn-info btn-block my-4' name='btnRemoveFavourite' type='submit' value='" . $listing['listing_id'] . "'>Remove From Favourites</button>
				  	</form>
                    </div>
                  </div><br/><br/>";
            $index++;
		}
	}

	function build_users_preview($users, $page_num, $header, $is_pending = false)
	{
		$records_left = count($users) - (($page_num-1) * NUM_RECORDS_PER_PAGE);
        $num_records = 0;
        if ($records_left < NUM_RECORDS_PER_PAGE) { $num_records = $records_left; }
        else { $num_records = NUM_RECORDS_PER_PAGE; }
        $get = "";
        $index = ($page_num-1) * NUM_RECORDS_PER_PAGE;
        
        for ($i = 0; $i < $num_records; $i++)
        {
			if (isset($_GET['page_num'])) { $get = "?page_num=" . $_GET['page_num']; }
			$user = $users[$index];
			$person = pg_fetch_assoc(get_user_personal_information($user['user_id']));
			echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . $get . "'>
					<div class='card'>
						<h5 class='card-header text-center'>" . $header . " User Info</h5>
						<div class='card-body'>
							<div class = 'row'>
								<p class='font-weight-bold col-sm-3 text-right'>User ID:</p>
								<p class='col'>" . $user['user_id'] . "</p>
								<p class='font-weight-bold col-sm-3 text-right'>City:</p>
								<p class='col'>" . $person['city'] . " " . $person['province'] . "</p>
							</div>
							<div class = 'row'>
								<p class='font-weight-bold col-sm-3 text-right'>Email Address:</p>
								<p class='col'>" . $user['email_address'] . "</p>
								<p class='font-weight-bold col-sm-3 text-right'>Phone Number:</p>
								<p class='col'>" . display_phone_number($person['primary_phone_number']) . "</p>
							</div>
							<div class = 'row'>
								<p class='font-weight-bold col-sm-3 text-right'>Name:</p>
								<p class='col'>" . $person['first_name'] . " " . $person['last_name'] . "</p>
								<p class='font-weight-bold col-sm-3 text-right'>Preferred Contact Method:</p>
								<p class='col'>" . get_property(PREFERRED_CONTACT_TABLE, $person['preferred_contact_method']) . "</p>
							</div>";
			if ($is_pending)
			{
				echo "<div class = 'row'>
						<div class='col'>
							<button class='btn btn-info btn-block my-4' name='btnDisable' type='submit' value='" . $user['user_id'] . "'>Disable User</button>
						</div>
						<div class='col'>
							<button class='btn btn-info btn-block my-4' name='btnEnable' type='submit' value='" . $user['user_id'] . "'>Enable User</button>
						</div>
					</div>";
			}
			else { echo "<button class='btn btn-info btn-block my-4' name='btnEnable' type='submit' value='" . $user['user_id'] . "'>Enable User</button>"; }
			echo "</div>
					</div>
				</form><br/>";
            $index++;
		}
	}

	function build_pagination_menu($num_pages, $page_num, $get_request = "")
	{
		if ($num_pages > 1)
        {
            $link = "";
            if ($page_num == 1) { $link = "#" . $get_request; }
            else { $link = "?page_num=" . ($page_num-1) . $get_request; }
            echo "<div class='d-flex justify-content-center'>
                    <nav>
                        <ul class='pagination'>
                            <li class='page-item'>
                            <a class='page-link' href='" . $link . "' aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span>
                                <span class='sr-only'>Previous</span>
                            </a>
                            </li>";

            for ($i = 0; $i < $num_pages; $i++)
            {
                echo "<li class='page-item'><a class='page-link' href='?page_num=" . ($i+1) . $get_request . "'>" . ($i+1) . "</a></li>";
            }

            $link = "";
            if ($page_num == $num_pages) { $link = "#" . $get_request; }
            else { $link = "?page_num=" . ($page_num+1) . $get_request; }

            echo "                 <a class='page-link' href='" . $link . "' aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span>
                                <span class='sr-only'>Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                </div>";
        }
	}

	function file_upload_errors($error)
	{
		$return_value = "";
		if ($error == UPLOAD_ERR_INI_SIZE) { $return_value = "The uploaded file exceeds the maximum file size: " . ini_get('upload_max_filesize'); }
		else if ($error == UPLOAD_ERR_FORM_SIZE) { $return_value = "The uploaded file exceeds the maximum file size"; }
		else if ($error == UPLOAD_ERR_PARTIAL) { $return_value = "The uploaded file was only partially uploaded."; }
		else if ($error == UPLOAD_ERR_NO_FILE) { $return_value = "No file was uploaded."; }
		else if ($error == UPLOAD_ERR_NO_TMP_DIR) { $return_value = "Missing a temporary folder."; }
		else if ($error == UPLOAD_ERR_CANT_WRITE) { $return_value = "Failed to write file to disk."; }
		else if ($error == UPLOAD_ERR_EXTENSION) { $return_value = "File upload stopped by extension."; }
		return $return_value;
	}
	 
	function rename_files($path, $num, $listing_id, $is_default)
	{
		$counter = 0; $default = $is_default;
		foreach (scandir($path) as $file)
		{
			if (strlen($file) > 4)
			{
				$counter++;
				if ($counter >= $num) 
				{
					if (!is_numeric(substr(basename($path . $file, EXT), -1))) { $default = "d"; }
					rename($path . $file, $path . $listing_id . "_" . $counter . $default . EXT);
					$default = "";
				}
			}
		}
	}

	function change_default_picture($path, $filename, $listing_id)
	{
		$counter = 0;
		foreach (scandir($path) as $file)
		{
			if (strlen($file) > 4)
			{
				$counter++;
				if (!is_numeric(substr(basename($path . $file, EXT), -1))) { rename($path . $file, $path . $listing_id . "_" . $counter . EXT); }
				else if (($path . $file) == $filename) { rename($path . $file, $path . $listing_id . "_" . $counter . "d" . EXT); }
			}
		}
	}
?>