<?php
	/*
		Group 18
		WEBD3201
		September 14, 2019
	*/
	// User types
	define ("ADMIN", "s");
	define ("AGENT", "a");
	define ("CLIENT", "c");
	define ("PENDING", "p");
	define ("DISABLED", "d");
	define ("DISABLED_AGENT", "da");
	// Databases constants
	define ("DB_HOST", "localhost");
	define ("DB_NAME", "group18");
	define ("DB_PORT", "5432");
	define ("DB_PASSWORD", "group18.ca");
	define ("DB_USER", "postgres");
	// Cookies
	define ("COOKIE_LIFESPAN", 2592000);
	// Hash
	define ("HASH_TYPE", "md5");
	// Preferred contact methods
	define ("CONTACT_EMAIL", "e");
	define ("CONTACT_PHONE", "p");
	define ("CONTACT_POSTED_MAIL", "l");
	// Listings statuses
	define ("STATUS_OPEN", "o");
	define ("STATUS_CLOSED", "c");
	define ("STATUS_SOLD", "s");
	define ("STATUS_HIDDEN", "h");
	define ("STATUS_DISABLED", "d");
	// Offensives status
	define ("OFFENSIVE_OPEN", "o");
	define ("OFFENSIVE_CLOSED", "c");
	// Phone number area codes
	define ("MIN_PHONE_CODE", 200);
	define ("MAX_PHONE_CODE", 999);
	// Validation Constants
	define ("MINIMUM_ID_LENGTH", 6);
	define ("MAXIMUM_ID_LENGTH", 20);
	define ("MINIMUM_PASSWORD_LENGTH", 8);
	define ("MAXIMUM_PASSWORD_LENGTH", 16);
	define ("MAX_FIRST_NAME_LENGTH", 128);
	define ("MAX_LAST_NAME_LENGTH", 128);
	define ("MAX_ADDRESS_LENGTH", 128);
	define ("MAX_EMAIL_LENGTH", 256);
	define ("MAX_CITY_LENGTH", 64);
	define ("POSTAL_CODE_LENGTH", 6);
	define ("CANADIAN_POSTAL_CODE", "/[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]/");
	define ("PHONE_NUMBER_LENGTH", 10);
	define ("CANADIAN_PHONE_NUMBER", "/[2-9][0-9]{2}[2-9][0-9]{6}/");
	// Table names
	define ("BASEMENT_TABLE", "basement_type");
	define ("BUILDING_TABLE", "building_type");
	define ("CITY_TABLE", "city");
	define ("FLOORING_TABLE", "flooring");
	define ("HOUSING_TYPE_TABLE", "housing_style");
	define ("LISTING_STATUS_TABLE", "listing_status");
	define ("LISTINGS_TABLE", "listings");
	define ("PARKING_TABLE", "parking");
	define ("PERSONS_TABLE", "persons");
	define ("PREFERRED_CONTACT_TABLE", "preferred_contact_method");
	define ("PROPERTY_OPTIONS_TABLE", "property_options");
	define ("PROVINCES_TABLE", "provinces");
	define ("SALUTATIONS_TABLE", "salutations");
	define ("TRANSACTION_TYPE_TABLE", "transaction_type");
	define ("USERS_TABLE", "users");
	define ("BATHROOMS_TABLE", "bathrooms");
	define ("BEDROOMS_TABLE", "bedrooms");
	define ("FAVOURITES_TABLE", "favourites");
	define ("OFFENSIVES_TABLE", "offensives");

	define ("NUM_RECORDS_PER_PAGE", 10);
	define ("MAX_SEARCH_RESULT", 200);

	define ("MAX_NUM_IMAGES", 6);
	define ("MAX_FILE_SIZE", 100000);

	define ("EXT", ".jpeg");
	define ("WEBSITE_EMAIL", "HANA@mail.ru");
?>