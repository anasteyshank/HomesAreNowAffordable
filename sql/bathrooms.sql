/*
	Group 18
	bathrooms.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS bathrooms;

CREATE TABLE bathrooms(
    value INT PRIMARY KEY,
    property INT NOT NULL
);

ALTER TABLE bathrooms OWNER TO group18_admin;

INSERT INTO bathrooms (value, property) VALUES (1, 1);
INSERT INTO bathrooms (value, property) VALUES (2, 2);
INSERT INTO bathrooms (value, property) VALUES (4, 3);
INSERT INTO bathrooms (value, property) VALUES (8, 4);
INSERT INTO bathrooms (value, property) VALUES (16, 5);