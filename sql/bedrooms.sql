/*
	Group 18
	bedrooms.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS bedrooms;

CREATE TABLE bedrooms(
    value INT PRIMARY KEY,
    property INT NOT NULL
);

ALTER TABLE bathrooms OWNER TO group18_admin;

INSERT INTO bedrooms (value, property) VALUES (1, 1);
INSERT INTO bedrooms (value, property) VALUES (2, 2);
INSERT INTO bedrooms (value, property) VALUES (4, 3);
INSERT INTO bedrooms (value, property) VALUES (8, 4);
INSERT INTO bedrooms (value, property) VALUES (16, 5);