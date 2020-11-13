/*
	Group 18
	housing_style.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS housing_style;

CREATE TABLE housing_style(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE housing_style OWNER TO group18_admin;

INSERT INTO housing_style (value, property) VALUES (1, 'Victorian');
INSERT INTO housing_style (value, property) VALUES (2, 'Modern');
INSERT INTO housing_style (value, property) VALUES (4, 'Craftsman');
INSERT INTO housing_style (value, property) VALUES (8, 'Traditional');