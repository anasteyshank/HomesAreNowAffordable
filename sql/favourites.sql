/*
	Group 18
	favourites.sql
	WEBD3201
	December 8, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS favourites;

CREATE TABLE favourites(
	user_id VARCHAR(20) NOT NULL REFERENCES users (user_id),
	listing_id INT NOT NULL REFERENCES listings (listing_id)
);

ALTER TABLE favourites OWNER TO group18_admin;