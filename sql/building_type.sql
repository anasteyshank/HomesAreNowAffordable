/*
	Group 18
	building_type.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS building_type;

CREATE TABLE building_type(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE building_type OWNER TO group18_admin;

INSERT INTO building_type (value, property) VALUES (1, 'Detached House');
INSERT INTO building_type (value, property) VALUES (2, 'Townhouse');
INSERT INTO building_type (value, property) VALUES (4, 'Apartment');
INSERT INTO building_type (value, property) VALUES (8, 'Condo');