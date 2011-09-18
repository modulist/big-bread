USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS watched_technologies;
CREATE TABLE watched_technologies(
  id            char(36)    NOT NULL,
  user_id       char(36)    COLLATE utf8_unicode_ci NOT NULL,
  technology_id char(36)    COLLATE utf8_unicode_ci NOT NULL,
  created       datetime    NULL,
  modified      datetime    NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__watched_tech__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__watched_tech__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE users
  ADD zip_code char(5) NULL AFTER password,
  ADD CONSTRAINT fk__users__us_zipcode FOREIGN KEY( zip_code )
    REFERENCES us_zipcode( zip )
    ON DELETE NO ACTION
    ON UPDATE CASCADE;
--  DROP show_questionnaire_instructions;

ALTER TABLE buildings
  ADD name varchar(255) NULL AFTER id;

SET foreign_key_checks = 1;
