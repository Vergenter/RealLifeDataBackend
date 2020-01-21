CREATE TABLE entry_type (
  entry_type_id smallserial NOT NULL,
  entry_type_name varchar(50) NOT NULL,
  PRIMARY KEY (entry_type_id)
);
INSERT INTO entry_type VALUES (1,'Object');
INSERT INTO entry_type VALUES (2,'Feature');

CREATE TABLE entry (
  entry_id serial NOT NULL ,
  entry_type_id smallint,
  entry_name varchar(50) NOT NULL,
  description varchar(50) DEFAULT NULL,
  PRIMARY KEY (entry_id),
  FOREIGN KEY (entry_type_id)
    REFERENCES entry_type(entry_type_id)
    ON DELETE CASCADE
);

CREATE TABLE data (
  entry_id int NOT NULL,
  creation_time TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
  value DECIMAL(20,10) NOT NULL,
  description varchar(50) DEFAULT NULL,
  PRIMARY KEY (entry_id),
  FOREIGN KEY (entry_id)
        REFERENCES entry(entry_id)
        ON DELETE CASCADE
);

CREATE TABLE restrictions (
  entry_id int NOT NULL,
  min_value DECIMAL(20,10) NOT NULL,
  max_value DECIMAL(20,10) NOT NULL,
  step DECIMAL(20,10) NOT NULL,
  PRIMARY KEY (entry_id),
    FOREIGN KEY (entry_id)
        REFERENCES entry(entry_id)
        ON DELETE CASCADE
);

CREATE TABLE role (
  role_id smallserial NOT NULL ,
  role_name varchar(50) NOT NULL,
  PRIMARY KEY (role_id)
);
INSERT INTO role VALUES (1,'Admin');
INSERT INTO role VALUES (2,'User');

CREATE TABLE account (
  account_id serial NOT NULL,
  account_name varchar(50) NOT NULL,
  hash varchar(50) NOT NULL,
  entry_id int NOT NULL,
  role_id smallint NOT NULL,
  FOREIGN KEY (role_id)
        REFERENCES role(role_id)
        ON DELETE CASCADE,
  FOREIGN KEY (entry_id)
        REFERENCES entry(entry_id)
        ON DELETE CASCADE,
  PRIMARY KEY (account_id)
);

CREATE TABLE blacklist (
  account_id int NOT NULL,
  jti int NOT NULL,
  PRIMARY KEY (account_id,jti),
  FOREIGN KEY (account_id)
        REFERENCES account(account_id)
        ON DELETE CASCADE
);

CREATE TABLE relation (
  parent_id integer NOT NULL,
  child_id integer NOT NULL,
  PRIMARY KEY (parent_id,child_id),
  FOREIGN KEY (parent_id)
        REFERENCES entry(entry_id)
        ON DELETE CASCADE,
  FOREIGN KEY (child_id)
        REFERENCES entry(entry_id)
        ON DELETE RESTRICT
);

CREATE OR REPLACE FUNCTION clean_child() RETURNS trigger AS $clean_child$
    BEGIN
		DELETE FROM entry e WHERE e.entry_id = OLD.child_id and OLD.child_id NOT IN (SELECT child_id from relation);
		RETURN NULL;
    END;
$clean_child$ LANGUAGE plpgsql;

CREATE TRIGGER try_clean_child
AFTER DELETE ON relation 
FOR EACH ROW
EXECUTE PROCEDURE clean_child();

CREATE VIEW full_account AS 
SELECT account_id, account_name , role_name
FROM account
NATURAL JOIN role ;

CREATE VIEW full_feature AS 
SELECT entry_id, entry_name, description, min_value, max_value,  step
FROM entry
NATURAL JOIN restrictions ;

INSERT INTO entry VALUES (1,1,'A',NULL);
INSERT INTO entry VALUES (2,1,'B',NULL);
INSERT INTO entry VALUES (3,1,'C',NULL);
INSERT INTO entry VALUES (4,1,'D',NULL);
INSERT INTO relation VALUES (1,2);
INSERT INTO relation VALUES (2,3);
INSERT INTO relation VALUES (4,3);

DELETE FROM entry
WHERE entry_id=1;

CREATE OR REPLACE FUNCTION double_to_numeric (num double precision)
RETURNS numeric AS $result$
BEGIN
   return num::numeric;
END;
$result$ LANGUAGE plpgsql;