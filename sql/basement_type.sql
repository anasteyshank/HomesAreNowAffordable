/*
	Group 18
	basement_type.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS basement_type;

CREATE TABLE basement_type(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE basement_type OWNER TO group18_admin;

INSERT INTO basement_type (value, property) VALUES (1, 'Finished');
INSERT INTO basement_type (value, property) VALUES (2, 'Unfinished');
INSERT INTO basement_type (value, property) VALUES (4, 'Walkout');
INSERT INTO basement_type (value, property) VALUES (8, 'Unavailable');
