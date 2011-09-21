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

ALTER TABLE technologies
  ADD CONSTRAINT fk__technologies__technology_groups FOREIGN KEY( technology_group_id )
    REFERENCES technology_groups( id )
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

INSERT INTO technology_groups( id, incentive_tech_group_id, name, parent_group_id, rebate_bar )
VALUES
  ( '4e7a5b45-387c-4ef6-81bb-22536e891b5e', 'KTCH', 'Kitchen', null, 1 ),
  ( '4e7a5b45-6054-4f0c-b939-22536e891b5e', 'LNDR', 'Laundry', null, 1 );

UPDATE technology_groups
   SET rebate_bar = 0
 WHERE incentive_tech_group_id = 'APP';

UPDATE technologies
   SET technology_group_id = '4e7a5b45-387c-4ef6-81bb-22536e891b5e' -- Kitchen
 WHERE incentive_tech_id IN ( 'COOK', 'DISHW', 'FREEZ', 'RFRG' );

UPDATE technologies
   SET technology_group_id = '4e7a5b45-6054-4f0c-b939-22536e891b5e' -- Laundry
 WHERE incentive_tech_id IN ( 'WASH', 'DRYER' );

SET foreign_key_checks = 1;
