/*
	Group 18
	listing_status.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS listing_status;

CREATE TABLE listing_status(
    value CHAR(1) PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

INSERT INTO listing_status(value, property) VALUES ('o', 'Open');
INSERT INTO listing_status(value, property) VALUES ('c', 'Closed');
INSERT INTO listing_status(value, property) VALUES ('s', 'Sold');