/*
	Group 18
	flooring.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS flooring;

CREATE TABLE flooring(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE flooring OWNER TO group18_admin;

INSERT INTO flooring (value, property) VALUES (1, 'Hardwood');
INSERT INTO flooring (value, property) VALUES (2, 'Laminated');
INSERT INTO flooring (value, property) VALUES (4, 'Carpet');
INSERT INTO flooring (value, property) VALUES (8, 'Tiles');
INSERT INTO flooring (value, property) VALUES (16, 'Mixed');
