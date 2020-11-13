/*
	Group 18
	preferred_contact_method.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS preferred_contact_method;

CREATE TABLE preferred_contact_method(
    value CHAR(1) PRIMARY KEY,
    property VARCHAR(30) NOT NULL
);

ALTER TABLE users OWNER TO group18_admin;

INSERT INTO preferred_contact_method(value, property) VALUES ('e', 'E-mail');
INSERT INTO preferred_contact_method(value, property) VALUES ('p', 'Phone Call');
INSERT INTO preferred_contact_method(value, property) VALUES ('l', 'Letter Post');