USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

DROP TABLE questionnaires;

-- Polymorphic table so that anything can be watched
DROP TABLE IF EXISTS watched_technologies; -- Original table name
DROP TABLE IF EXISTS watch_lists;
CREATE TABLE watch_lists(
  id            char(36)      NOT NULL,
  user_id       char(36)      COLLATE utf8_unicode_ci NOT NULL,
  foreign_key   char(36)      COLLATE utf8_unicode_ci NOT NULL,
  model         varchar(255)  NOT NULL,
  created       datetime      NULL,
  modified      datetime      NULL,

  PRIMARY KEY( id ),
  CONSTRAINT fk__watch_lists__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__watch_lists__technologies FOREIGN KEY( foreign_key )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT uix_watch_lists UNIQUE INDEX( user_id, foreign_key, model )
) ENGINE=InnoDB;

ALTER TABLE users
  DROP deleted,
  DROP show_questionnaire_instructions,
  ADD active boolean NOT NULL DEFAULT 1 AFTER last_login,
  ADD zip_code char(5) NULL AFTER password,
  ADD CONSTRAINT fk__users__us_zipcode FOREIGN KEY( zip_code )
    REFERENCES us_zipcode( zip )
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

ALTER TABLE buildings
  ADD name varchar(255) NULL AFTER id;

ALTER TABLE technologies
  ADD CONSTRAINT fk__technologies__technology_groups FOREIGN KEY( technology_group_id )
    REFERENCES technology_groups( id )
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

INSERT INTO technology_groups( id, incentive_tech_group_id, name, title, parent_group_id, rebate_bar )
VALUES
  ( '4e7a5b45-387c-4ef6-81bb-22536e891b5e', 'KTCH', 'Kitchen', 'Kitchen', null, 1 ),
  ( '4e7a5b45-6054-4f0c-b939-22536e891b5e', 'LNDR', 'Laundry', 'Laundry', null, 1 );

UPDATE technology_groups
   SET rebate_bar = 0
 WHERE incentive_tech_group_id = 'APP';

ALTER TABLE technology_groups
  CHANGE rebate_bar display boolean NOT NULL DEFAULT 0,
  ADD display_order int NULL;
  
UPDATE technology_groups
   SET display_order = 1
 WHERE incentive_tech_group_id = 'HVAC';

UPDATE technology_groups
   SET display_order = 2,
       name = 'Building Shell'
 WHERE incentive_tech_group_id = 'ENV';

UPDATE technology_groups
   SET display_order = 3
 WHERE incentive_tech_group_id = 'KTCH';

UPDATE technology_groups
   SET display_order = 4
 WHERE incentive_tech_group_id = 'LNDR';

UPDATE technology_groups
   SET display_order = 5
 WHERE incentive_tech_group_id = 'HW';

UPDATE technology_groups
   SET display_order = 6
 WHERE incentive_tech_group_id = 'LIGHT';
 
UPDATE technology_groups
   SET display = 0
 WHERE incentive_tech_group_id IN ( 'OTH','WHOLE' ); 

UPDATE technologies
   SET technology_group_id = '4e7a5b45-387c-4ef6-81bb-22536e891b5e' -- Kitchen
 WHERE incentive_tech_id IN( 'COOK', 'DISHW', 'FREEZ', 'RFRG' );

UPDATE technologies
   SET technology_group_id = '4e7a5b45-6054-4f0c-b939-22536e891b5e' -- Laundry
 WHERE incentive_tech_id IN( 'WASH', 'DRYER' );
 
UPDATE technologies
   SET display = 0
 WHERE incentive_tech_id IN( 'AIRSL', 'CEILF', 'CHP', 'CTRL', 'DHUM', 'DRHR', 'FIREPL', 'INS', 'LCTRL', 'MAINT', 'MOTOR', 'OTHER', 'POOLP', 'PSHEAT', 'PTHST', 'PV', 'RMAC', 'SHOWER', 'SIDING', 'STEAM', 'WBLD', 'WHFAN', 'WHINS', 'WIND' );
/*
ALTER TABLE products
  DROP INDEX uix__products__make_model_energy,
  ADD CONSTRAINT uix__products__make_model UNIQUE INDEX( make, model );
*/
SET foreign_key_checks = 1;
