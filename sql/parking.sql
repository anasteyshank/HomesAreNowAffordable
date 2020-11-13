/*
	Group 18
	parking.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS parking;

CREATE TABLE parking(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE parking OWNER TO group18_admin;

INSERT INTO parking (value, property) VALUES (1, 'Reserved');
INSERT INTO parking (value, property) VALUES (2, 'Pay-As-You-Park');
INSERT INTO parking (value, property) VALUES (4, 'Parking Garage');
INSERT INTO parking (value, property) VALUES (8, 'Unavailable');