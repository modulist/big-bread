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

SET foreign_key_checks = 1;
