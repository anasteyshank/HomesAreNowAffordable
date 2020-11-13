/*
	Group 18
	offensives.sql
	WEBD3201
	December 8, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS offensives;

CREATE TABLE offensives(
	user_id VARCHAR(20) NOT NULL REFERENCES users (user_id),
	listing_id INT NOT NULL REFERENCES listings (listing_id),
	reported_on DATE NOT NULL,
	status CHAR(1),
	PRIMARY KEY (user_id, listing_id)
);

ALTER TABLE offensives OWNER TO group18_admin;