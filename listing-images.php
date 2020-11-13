<?php 
	/*
		Group 18
		WEBD3201
		December 8, 2019
	*/
	$title = "Manage Listing Images";
	$file = "listing-images.php";
	$description = "This is a page for managing listing images of a web site created for WEBD3201";
	$date = "December 8, 2019";
	$banner = "Manage Listing Images";

	require 'header.php';
	
	if (!isset($_SESSION['user']))
	{
		$_SESSION['warning_msg'] = "Please log in to access the requested page.";
		redirect('login.php');
	}
	else if ($_SESSION['user']['user_type'] == CLIENT) { redirect('welcome.php'); }
	else if ($_SESSION['user']['user_type'] != AGENT)
	{
		$_SESSION['warning_msg'] = "You are not logged in as " . $message;
		redirect('index.php');
	}
	else 
	{
		if (isset($_GET['listing_id']))
		{
			$listing_info = get_one_listing($_GET['listing_id']);
			if ($listing_info['user_id'] != $_SESSION['user']['user_id'])
			{
				$_SESSION['warning_msg'] = "You can only access this page for your listing.";
				redirect('dashboard.php');
			}
		}
		else { $_SESSION['warning_msg'] = "You can only access this page for your listing."; redirect('dashboard.php'); }
	}
	$error = "";
	$num_images = 0;
	$images_dir = "images/" . $listing_info['listing_id'];

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$listing_info = get_one_listing($_GET['listing_id']);
		$error = "";
		if (isset($_POST['btnUpload'])) 
		{
			$images = $_FILES['images'];
			$num_images = count($images['name']);
			if ($num_images != 0)
			{
				if (($num_images + $listing_info['images']) > MAX_NUM_IMAGES) { $error = "Maximum number of images you can upload is " . MAX_NUM_IMAGES; }
				else
				{
					for ($i = 0; $i < $num_images; $i++)
					{
						$error = file_upload_errors($images['error'][$i]);
						if ($error == "")
						{
							if ($images['type'][$i] != "image/jpeg") { $error = "Please only upload JPEG images."; break; }
							else if ($images['size'][$i] > MAX_FILE_SIZE) { $error = "The uploaded file exceeds the maximum file size allowed: " . (MAX_FILE_SIZE/1000) . "kB."; break; }
						}
						else { break; }
					}
					if ($error == "")
					{
						$image_num = $listing_info['images'];
						echo $image_num;
						$set_default = false;
						if (!is_dir($images_dir)) { mkdir($images_dir); $set_default = true; }
						for ($i = 0; $i < $num_images; $i++)
						{
							$default = "";
							if ($set_default && $i == 0) { $default = "d"; }
							$image_num += 1;
							move_uploaded_file($images['tmp_name'][$i], $images_dir . "/" . $listing_info['listing_id'] . "_" . $image_num . $default . EXT);
						}
						update_num_images($listing_info['listing_id'], $image_num);
						redirect($_SERVER['PHP_SELF'] . "?listing_id=" . $_GET['listing_id']);
					}
				}
			}
		}
		else if (isset($_POST['btnDelete']))
		{
			if (!isset($_POST['img_selected'])) { $error = "You haven't selected any image."; }
			else 
			{ 
				$is_default = "";
				$img_selected = $_POST['img_selected'];
				update_num_images($listing_info['listing_id'], $listing_info['images'] - count($img_selected));
				$rename_from = substr(basename($img_selected[0], EXT), -1);
				if (!is_numeric($rename_from)) { $is_default = $rename_from; $rename_from = substr(basename($img_selected[0], EXT), -2, -1); }
				foreach($img_selected as $image) { unlink($image); }
				if ($listing_info['images'] - count($img_selected) != 0) { rename_files($images_dir . "/", $rename_from, $listing_info['listing_id'], $is_default); }
				else { rmdir($images_dir); }
			}
			redirect($_SERVER['PHP_SELF'] . "?listing_id=" . $_GET['listing_id']);
		}
		else if (isset($_POST['btnDefault']))
		{
			change_default_picture($images_dir . "/", $_POST['btnDefault'], $listing_info['listing_id']);
			redirect($_SERVER['PHP_SELF'] . "?listing_id=" . $_GET['listing_id']);
		}
	}
?>

<div class="container fixed-footer">
	<br/>
	<p class="h4 mb-4 text-center">Manage your images</p>
	<hr/>
	<?php 
		if ($listing_info['images'] < MAX_NUM_IMAGES)
		{
			echo "<form class='text-center border border-light p-5' enctype='multipart/form-data' method='post' action='" .  $_SERVER['PHP_SELF'] . "?listing_id=" . $_GET['listing_id'] . "'>
					<input type='file' name='images[]' value='' class='file-upload btn btn-secondary btn-block rounded-pill shadow' multiple /><br/>
					<input type='submit' name='btnUpload' class='btn btn-primary' value='Upload Images' />" . fields_warning_message($error) . 
				 "</form><hr/>";
		}
		else { echo "<p>Maximum number of images uploaded. Please delete some your images to upload more.</p><hr/>"; }
		if ($listing_info['images'] == 0) { echo "<p>You haven't uploaded any images yet.</p>"; }
		else 
		{
			echo "<form class='text-center border border-light p-5' enctype='multipart/form-data' method='post' action='" .  $_SERVER['PHP_SELF'] . "?listing_id=" . $_GET['listing_id'] . "'>
					<div class='card-deck'>";
			$dir = $images_dir . "/";
			$files = scandir($dir);
			$counter = 0;
			foreach($files as $file) 
			{
				if (strlen($file) > 4)
				{
					$counter++;
					$file_name = $dir . $file;
					if (!is_numeric(substr(basename($file_name, EXT), -1)))
					{
						echo "<div class='card col-3'>
								<input type='checkbox' name='img_selected[]' value='" . $file_name . "' />
								<img src='" . $file_name . "' class='card-img-top img_upload' alt='House Picture' /><br/>
								<p class='font-weight-bold'>Default Picture</p>
							</div><br/>";
					}
					else
					{
						echo "<div class='card col-3'>
								<input type='checkbox' name='img_selected[]' value='" . $file_name . "' />
								<img src='" . $file_name . "' class='card-img-top img_upload' alt='House Picture' />
								<p><button class='btn btn-info btn-block my-4' type='submit' name='btnDefault' value='" . $file_name . "'>Set As Default</button></p>
							</div><br/>";
					}
					
					if ($counter % 3 == 0)
					{
						echo "</div><br/>
							<div class='card-deck'>";
					}
				}
			}
			echo "	</div>
					<p><button class='btn btn-info btn-block my-4' name='btnDelete' type='submit' value='Delete'>Delete Images</button></p>
				</form>";
		}
	?>
</div>

<?php include 'footer.php'; ?>