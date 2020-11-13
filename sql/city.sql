/*
	Group 18
	city.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS city;

CREATE TABLE city(
    value SMALLINT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE city OWNER TO group18_admin;

INSERT INTO city (value, property) VALUES (1, 'Ajax');
INSERT INTO city (value, property) VALUES (2, 'Brooklin');
INSERT INTO city (value, property) VALUES (4, 'Bowmanville');
INSERT INTO city (value, property) VALUES (8, 'Oshawa');
INSERT INTO city (value, property) VALUES (16, 'Pickering');
INSERT INTO city (value, property) VALUES (32, 'Port Perry');
INSERT INTO city (value, property) VALUES (64, 'Whitby');