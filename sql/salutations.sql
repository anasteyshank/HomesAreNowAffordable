/*
	Group 18
	salutations.sql
	WEBD3201
	October 26, 2019
*/
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS salutations;

CREATE TABLE salutations(
    property VARCHAR(10) NOT NULL
);

ALTER TABLE salutations OWNER TO group18_admin;

INSERT INTO salutations VALUES ('Master');
INSERT INTO salutations VALUES ('Mr.');
INSERT INTO salutations VALUES ('Miss');
INSERT INTO salutations VALUES ('Mrs.');
INSERT INTO salutations VALUES ('Ms.');