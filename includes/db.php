<?php
    /*
        Group 18
        WEBD3201
        September 14, 2019
    */
    function db_connect() 
    {
        return pg_connect("host=" . DB_HOST . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASSWORD);
    }
    
    function get_user_information($value1, $value2)
    {
        $stmt = pg_prepare(db_connect(), 'get_user_info', 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = $1 AND password = $2');
        return pg_execute(db_connect(), 'get_user_info', array($value1, $value2));
    }

    function get_user($value1)
    {
        $stmt = pg_prepare(db_connect(), 'get_user', 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = $1');
        return pg_execute(db_connect(), 'get_user', array($value1));
    }

    function get_user_personal_information($value)
    {
        $query = 'SELECT * FROM ' . PERSONS_TABLE . ' WHERE user_id = \'' . $value . '\';';
        return pg_query(db_connect(), $query);
    }

    function is_user_id($value)
    {
        $return_value = false;
        $stmt = pg_prepare(db_connect(), 'get_user_info', 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = $1');
        $result = pg_execute(db_connect(), 'get_user_info', array($value));
        if (pg_num_rows($result) > 0) { $return_value = true; }
        return $return_value;
    }

    function is_user_email($id, $email)
    {
        $return_value = false;
        $stmt = pg_prepare(db_connect(), 'get_email', 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = $1 and email_address=$2');
        $result = pg_execute(db_connect(), 'get_email', array($id, $email));
        if (pg_num_rows($result) > 0) { $return_value = true; }
        return $return_value;
    }

    function update_last_access($value)
    {
        $stmt = pg_prepare(db_connect(), 'update_last_access', 'UPDATE ' . USERS_TABLE . ' SET last_access = $1 WHERE user_id = $2');
        pg_execute(db_connect(), 'update_last_access', array(date("Y-m-d", time()), $value));
    }

    function build_simple_dropdown($table_name, $value)
	{
		$stmt = pg_prepare(db_connect(), $table_name, 'SELECT * FROM ' . $table_name);
		$result = pg_execute(db_connect(), $table_name, array());
		echo "<select class='form-control' name='" . $table_name . "'>
				<option hidden='hidden'>" . $value . "</option>
				<option>&nbsp;</option>";
		
		while ($row = pg_fetch_row($result))
		{
			echo "<option>" . $row[0] . "</option>";
		}
		echo "	</select>";
	}

	function build_dropdown($table_name, $value)
	{
		echo "<select class='form-control' name='" . $table_name . "'>
				<option hidden='hidden'>" . $value . "</option>
				<option>&nbsp;</option>";
		$stmt = pg_prepare(db_connect(), $table_name, 'SELECT * FROM ' . $table_name);
		$result = pg_execute(db_connect(), $table_name, array());
		
		while ($row = pg_fetch_row($result))
		{
			echo "<option>" . $row[1] . "</option>";
		}
		echo "	</select>";
	}

	function build_radio($table_name, $value)
	{
		$stmt = pg_prepare(db_connect(), $table_name, 'SELECT * FROM ' . $table_name);
		$result = pg_execute(db_connect(), $table_name, array());

		while ($row = pg_fetch_row($result))
		{
			echo "<div class='form-check-inline pull-left'>";
			if ($row[0] == $value)
			{
				echo "<label class='form-check-label' active'>
						<input type='radio' class='form-check-input' name='" . $table_name . "' value='" . $row[0] . "' checked/>" . $row[1];
			}
			else
			{
				echo "<label class='form-check-label'>
						<input type='radio' class='form-check-input' name='" . $table_name . "' value='" . $row[0] . "'/>" . $row[1];
							
			}
			echo "	</label>
				  </div>";
		}
    }

    function get_property($table_name, $value)
    {
        $stmt = 'SELECT * FROM ' . $table_name;
        $result = pg_query(db_connect(), $stmt);
        
        $return_value = "";

        while ($row = pg_fetch_row($result))
		{
            if ($row[0] == $value) { $return_value = $row[1]; }
        }
        return $return_value;
    }

    function get_value($table_name, $value)
    {
        $stmt = 'SELECT * FROM ' . $table_name;
        $result = pg_query(db_connect(), $stmt);

        $return_value = "";

        while ($row = pg_fetch_row($result))
		{
            if ($row[1] == $value) { $return_value = $row[0]; }
        }
        return $return_value;
    }

    function insert_into_users($array)
    {
        $stmt = pg_prepare(db_connect(), USERS_TABLE, 'INSERT INTO ' . USERS_TABLE . '(user_id, password, email_address, user_type, enroll_date, last_access) 
                                                       VALUES ($1, $2, $3, $4, $5, $6);');
        pg_execute(db_connect(), USERS_TABLE, $array);
    }

    function update_user_info($array)
    {
        $stmt = pg_prepare(db_connect(), "update_users", 'UPDATE users SET email_address=$1 WHERE user_id=$2;');
        pg_execute(db_connect(), "update_users", $array);
    }

    function insert_into_persons($array)
    {
        $stmt = pg_prepare(db_connect(), PERSONS_TABLE, 'INSERT INTO ' . PERSONS_TABLE . '(user_id, salutation, first_name, last_name, street_address1, street_address2, city, province, 
                                                         postal_code, primary_phone_number, secondary_phone_number, fax_number, preferred_contact_method)
                                                         VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13);');
        pg_execute(db_connect(), PERSONS_TABLE, $array);
    }

    function update_person_info($array)
    {
        $stmt = pg_prepare(db_connect(), "update_persons", 'UPDATE persons SET salutation=$1, first_name=$2, last_name=$3, street_address1=$4, street_address2=$5, city=$6, province=$7, 
                                                         postal_code=$8, primary_phone_number=$9, secondary_phone_number=$10, fax_number=$11, preferred_contact_method=$12 WHERE user_id=$13;');
        pg_execute(db_connect(), "update_persons", $array);
    }

    function build_checkbox($table_name, $value)
	{
		$stmt = 'SELECT * FROM ' . $table_name;
		$result = pg_query(db_connect(), $stmt);

		while ($row = pg_fetch_row($result))
		{
            $checked = "";
            if (!empty($value)) 
            { 
                foreach ($value as $arg) 
                { 
                    if (is_array($arg)) { foreach ($arg as $arg2) { if ($arg2 == strval($row[0])) { $checked = "checked"; } } }
                    else { if ($arg == strval($row[1])) { $checked = "checked"; } }
                } 
            }
            echo "<label class='checkbox'><input type='checkbox' name='" . $table_name . "[]' value='". $row[0] . "'" . $checked . "/>" . $row[1] . "&nbsp;&nbsp;&nbsp;&nbsp;</label>";
        }
        echo "<p>&nbsp;</p>";
    }

    function insert_into_listings($array)
    {
        $stmt = pg_prepare(db_connect(), LISTINGS_TABLE, 'INSERT INTO ' . LISTINGS_TABLE . ' (listing_id, user_id, status, price, headline, description, postal_code, 
                                                                     images, city, property_options, bedrooms, bathrooms, building_type, transaction_type, basement_type, parking,
                                                                     housing_style, flooring) VALUES (DEFAULT, $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17);');
        pg_execute(db_connect(), LISTINGS_TABLE, $array);
    }
    
    function update_listings($array)
    {
        $stmt = pg_prepare(db_connect(), "update" + LISTINGS_TABLE, 'UPDATE ' . LISTINGS_TABLE . ' SET status=$1, price=$2, headline=$3, description=$4, postal_code=$5, 
                                                                    images=$6, city=$7, property_options=$8, bedrooms=$9, bathrooms=$10, building_type=$11, transaction_type=$12, basement_type=$13, parking=$14,
                                                                    housing_style=$15, flooring=$16 WHERE listing_id=$17;');
        pg_execute(db_connect(), "update" + LISTINGS_TABLE, $array);
    }

    function get_checked_values($table_name, $value)
    {
        $stmt = 'SELECT * FROM ' . $table_name . " ORDER BY value DESC";
        $result = pg_query(db_connect(), $stmt);
        
        $array = [];

        while (($row = pg_fetch_row($result)) && ($value <> 0))
		{
            if (($value - intval($row[0])) >= 0)
            {
                array_push($array, $row[1]);
                $value -= intval($row[0]);
            }
        }
        return $array;
    }

    function get_listings_list($cities, $bedrooms, $bathrooms, $properties, $housing_style, $flooring, $building_type, $transaction_type, $basement_type, $parking, $min_price, $max_price)
    {
        $query = 'SELECT listing_id FROM listings WHERE (';
        for ($i = 0; $i < count($cities)-1; $i++) { $query .= 'city='; $query .= get_value(CITY_TABLE, $cities[$i]); $query .= ' OR '; }
        $query .= 'city=';
        $query .= get_value(CITY_TABLE, $cities[count($cities)-1]);
        $query .= ')';

        if (!empty($bedrooms))
        {
            $query .= " AND (";
            for ($i = 0; $i < count($bedrooms[0])-1; $i++) { $query .= 'bedrooms='; $query .= $bedrooms[0][$i]; $query .= ' OR '; }
            $query .= 'bedrooms=';
            $query .= $bedrooms[0][count($bedrooms[0])-1];
            $query .= ')';
        }

        if (!empty($bathrooms))
        {
            $query .= " AND (";
            for ($i = 0; $i < count($bathrooms[0])-1; $i++) { $query .= 'bathrooms='; $query .= $bathrooms[0][$i]; $query .= ' OR '; }
            $query .= 'bathrooms=';
            $query .= $bathrooms[0][count($bathrooms[0])-1];
            $query .= ')';
        }

        if (!empty($properties))
        {
            $query .= " AND (";
            for ($i = 0; $i < count($properties[0])-1; $i++) { $query .= 'property_options='; $query .= $properties[0][$i]; $query .= ' OR '; }
            $query .= 'property_options=';
            $query .= $properties[0][count($properties[0])-1];
            $query .= ')';
        }
        
        if (is_numeric($housing_style)) { $query .= " AND ("; $query .= "housing_style="; $query .= get_value(HOUSING_TYPE_TABLE, $housing_style); $query .= ")";}
        if (is_numeric($flooring)) { $query .= " AND ("; $query .= "flooring="; $query .= get_value(FLOORING_TABLE, $flooring); $query .= ")";}
        if (is_numeric($building_type)) { $query .= " AND ("; $query .= "building_type="; $query .= get_value(BUILDING_TABLE, $building_type); $query .= ")";}
        if (is_numeric($transaction_type)) { $query .= " AND ("; $query .= "transaction_type="; $query .= get_value(TRANSACTION_TYPE_TABLE, $transaction_type); $query .= ")";}
        if (is_numeric($basement_type)) { $query .= " AND ("; $query .= "basement_type="; $query .= get_value(BASEMENT_TABLE, $basement_type); $query .= ")";}
        if (is_numeric($parking)) { $query .= " AND ("; $query .= "parking="; $query .= get_value(PARKING_TABLE, $parking); $query .= ")";}

        if ($min_price <> "" && $max_price <> "") { $query .= " AND (price >="; $query .= $min_price; $query .= " AND price <="; $query .= $max_price; $query .= ")";}
        else if ($min_price <> "") { $query .= " AND (price >="; $query .= $min_price; $query .= ")";}
        else if ($max_price <> "") { $query .= " AND (price <="; $query .= $max_price; $query .= ")";}
        
        $query .= " AND status='o' ORDER BY listing_id DESC LIMIT 200;";

        return pg_query(db_connect(), $query);
    }

    function get_one_listing($id)
    {
        $query = 'SELECT * FROM ' . LISTINGS_TABLE . ' WHERE listing_id='.$id;
        $result = pg_query(db_connect(), $query);
        return pg_fetch_assoc($result);
    }

    function get_agent_listings($agent_id, $listing_type)
    {
        $query = 'SELECT * FROM ' . LISTINGS_TABLE . ' WHERE user_id=\'' . $agent_id . '\' AND status=\'' . $listing_type . '\' ORDER BY listing_id DESC';
        $result = pg_query(db_connect(), $query);
        return pg_fetch_all($result);
    }

    function get_favourites_list($client_id)
    {
        $query = 'SELECT * FROM ' . FAVOURITES_TABLE . ' WHERE user_id=\'' . $client_id . '\'';
        $result = pg_query(db_connect(), $query);
        return pg_fetch_all($result);
    }

    function get_last_listings()
    {
        $query = "SELECT listing_id FROM listings WHERE status='o' ORDER BY listing_id DESC LIMIT " . MAX_SEARCH_RESULT . ";";
        $result = pg_query(db_connect(), $query);
        return pg_fetch_all($result);
    }

    function update_password($array)
    {
        $stmt = pg_prepare(db_connect(), "update_password", 'UPDATE users SET password=$1 WHERE user_id=$2;');
        pg_execute(db_connect(), "update_password", $array);
    }

    function get_num_records($table_name)
    {
        $result = pg_query(db_connect(), 'SELECT COUNT(*) FROM ' . $table_name);
        return pg_fetch_row($result);
    }

    function update_num_images($listing_id, $num_images)
    {
        $stmt = pg_prepare(db_connect(), 'update_num_images', 'UPDATE ' . LISTINGS_TABLE . ' SET images = $1 WHERE listing_id = $2');
        pg_execute(db_connect(), 'update_num_images', array($num_images, $listing_id));
    }

    function hide_listing($listing_id)
    {
        $stmt = pg_prepare(db_connect(), 'hide_listing', 'UPDATE ' . LISTINGS_TABLE . ' SET status = \'' . STATUS_HIDDEN . '\' WHERE listing_id = $1');
        pg_execute(db_connect(), 'hide_listing', array($listing_id));
    }

    function disable_listing($listing_id)
    {
        $stmt = pg_prepare(db_connect(), 'disable_listing', 'UPDATE ' . LISTINGS_TABLE . ' SET status = \'' . STATUS_DISABLED . '\' WHERE listing_id = $1');
        pg_execute(db_connect(), 'disable_listing', array($listing_id));
    }

    function disable_user($user_id, $type = DISABLED)
    {
        $stmt = pg_prepare(db_connect(), 'disable_user', 'UPDATE ' . USERS_TABLE . ' SET user_type = \'' . $type . '\' WHERE user_id = $1');
        pg_execute(db_connect(), 'disable_user', array($user_id));
    }

    function enable_user($user_id, $type = AGENT)
    {
        $stmt = pg_prepare(db_connect(), 'enable_user', 'UPDATE ' . USERS_TABLE . ' SET user_type = \'' . $type . '\' WHERE user_id = $1');
        pg_execute(db_connect(), 'enable_user', array($user_id));
    }

    function is_in_favourites($user_id, $listing_id)
    {
        $return_value = false;
        $query = 'SELECT * FROM ' . FAVOURITES_TABLE . ' WHERE user_id = \'' . $user_id . '\' AND listing_id=\'' . $listing_id . '\';';
        $result = pg_query(db_connect(), $query);
        if (pg_num_rows($result) > 0) { $return_value = true; }
        return $return_value;
    }

    function add_to_favourites($user_id, $listing_id)
    {
        $stmt = pg_prepare(db_connect(), "add_to_favourites", 'INSERT INTO ' . FAVOURITES_TABLE . ' (user_id, listing_id) VALUES ($1, $2);');
        pg_execute(db_connect(), "add_to_favourites", array($user_id, $listing_id));
    }
    
    function remove_from_favourites($user_id, $listing_id="")
    {
        if ($listing_id == "")
        {
            $stmt = pg_prepare(db_connect(), "remove_from_favourites_user", 'DELETE FROM ' . FAVOURITES_TABLE . ' WHERE user_id=$1;');
            pg_execute(db_connect(), "remove_from_favourites_user", array($user_id));
        }
        else if ($user_id == "")
        {
            $stmt = pg_prepare(db_connect(), "remove_from_favourites_listing", 'DELETE FROM ' . FAVOURITES_TABLE . ' WHERE listing_id=$1;');
            pg_execute(db_connect(), "remove_from_favourites_listing", array($listing_id));
        }
        else 
        {
            $stmt = pg_prepare(db_connect(), "remove_from_favourites", 'DELETE FROM ' . FAVOURITES_TABLE . ' WHERE user_id=$1 AND listing_id=$2;');
            pg_execute(db_connect(), "remove_from_favourites", array($user_id, $listing_id));
        }
    }

    function has_reported_listing($user_id, $listing_id)
    {
        $return_value = false;
        $query = 'SELECT * FROM ' . OFFENSIVES_TABLE . ' WHERE user_id = \'' . $user_id . '\' AND listing_id=\'' . $listing_id . '\';';
        $result = pg_query(db_connect(), $query);
        if (pg_num_rows($result) > 0) { $return_value = true; }
        return $return_value;
    }

    function report_listing($user_id, $listing_id)
    {
        $stmt = pg_prepare(db_connect(), "report_listing", 'INSERT INTO ' . OFFENSIVES_TABLE . ' (user_id, listing_id, reported_on, status) VALUES ($1, $2, $3, $4);');
        pg_execute(db_connect(), "report_listing", array($user_id, $listing_id, date("Y-m-d", time()), OFFENSIVE_OPEN));
    }

    function get_offensives($status)
    {
        $query = 'SELECT * FROM ' . OFFENSIVES_TABLE . ' WHERE status=\'' . $status . '\'';
        $result = pg_query(db_connect(), $query);
        return pg_fetch_all($result);
    }

    function is_in_offensives($listing_id)
    {
        $return_value = false;
        $query = 'SELECT * FROM ' . OFFENSIVES_TABLE . ' WHERE listing_id = \'' . $listing_id . '\';';
        $result = pg_query(db_connect(), $query);
        if (pg_num_rows($result) > 0) { $return_value = true; }
        return $return_value;
    }

    function close_offensives($id, $is_listing=true)
    {
        if ($is_listing)
        {
            $stmt = pg_prepare(db_connect(), "close_offensives", 'UPDATE ' . OFFENSIVES_TABLE . ' SET status=$1 WHERE listing_id=$2;');
            pg_execute(db_connect(), "close_offensives", array(OFFENSIVE_CLOSED, $id));
        }
        else 
        {
            $stmt = pg_prepare(db_connect(), "close_offensives_user", 'UPDATE ' . OFFENSIVES_TABLE . ' SET status=$1 WHERE user_id=$2;');
            pg_execute(db_connect(), "close_offensives_user", array(OFFENSIVE_CLOSED, $id));
        }
    }

    function get_users($type)
    {
        $query = 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_type = \'' . $type . '\' ORDER BY enroll_date DESC;';
        return pg_query(db_connect(), $query);
    }
?>