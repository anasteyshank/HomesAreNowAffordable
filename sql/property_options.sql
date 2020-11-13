/*
	Group 18
	property_options.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS property_options;

CREATE TABLE property_options(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE property_options OWNER TO group18_admin;

INSERT INTO property_options (value, property) VALUES (1, 'Garage');
INSERT INTO property_options (value, property) VALUES (2, 'AC');
INSERT INTO property_options (value, property) VALUES (4, 'Pool');
INSERT INTO property_options (value, property) VALUES (8, 'Acreage');
INSERT INTO property_options (value, property) VALUES (16, 'Waterfront');