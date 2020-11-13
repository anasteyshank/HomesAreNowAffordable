/*
	Group 18
	transaction_type.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS transaction_type;

CREATE TABLE transaction_type(
    value INT PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE transaction_type OWNER TO group18_admin;

INSERT INTO transaction_type (value, property) VALUES (1, 'For Sale');
INSERT INTO transaction_type (value, property) VALUES (2, 'For Rent');
INSERT INTO transaction_type (value, property) VALUES (4, 'For Lease');