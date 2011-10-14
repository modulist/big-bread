USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS questionnaires;

DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
  id            char(36)      NOT NULL,
  transport     varchar(255)  NOT NULL DEFAULT 'email',
  type          varchar(255)  NULL,
  sender_id     char(36)      COLLATE utf8_unicode_ci NOT NULL,
  recipient_id  char(36)      COLLATE utf8_unicode_ci NOT NULL,
  sent          boolean       NOT NULL DEFAULT 0,
  created       datetime      NULL,
  modified      datetime      NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__messages__senders FOREIGN KEY( sender_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__messages__recipients FOREIGN KEY( recipient_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Merging products and building_products into one table: fixtures
DROP TABLE IF EXISTS fixtures;
RENAME TABLE building_products TO fixtures;
ALTER TABLE fixtures
  DROP FOREIGN KEY fk__building_products__products,
  DROP FOREIGN KEY fk__building_products__buildings,
  DROP INDEX uix__building_products__serial_number,
  ADD energy_source_id  varchar(6)    NULL AFTER product_id,
  ADD model             varchar(255)  NULL AFTER product_id,
  ADD make              varchar(255)  NULL AFTER product_id,
  ADD name              varchar(255)  NULL AFTER product_id,
  ADD technology_id     char(36)      NOT NULL AFTER product_id,
  ADD year_installed    int           NULL AFTER service_in;

UPDATE fixtures f, products p
   SET f.technology_id    = p.technology_id,
       f.make             = p.make,
       f.model            = p.model,
       f.energy_source_id = p.energy_source_id
 WHERE f.product_id = p.id;
 
DROP TABLE products;

UPDATE fixtures
   SET year_installed = YEAR(service_in);

ALTER TABLE fixtures
  DROP product_id,
  DROP service_in,
  CHANGE year_installed service_in int NULL,
  ADD CONSTRAINT fk__fixtures__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  ADD CONSTRAINT fk__fixtures__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  ADD CONSTRAINT fk__fixtures__incentive_tech_energy_type FOREIGN KEY( energy_source_id )
    REFERENCES incentive_tech_energy_type( incentive_tech_energy_type_id )
    ON UPDATE CASCADE
    ON DELETE CASCADE;

-- Polymorphic table so that anything can be watched
DROP TABLE IF EXISTS watched_technologies; -- Original table name
DROP TABLE IF EXISTS watch_lists;
CREATE TABLE watch_lists(
  id            char(36)      NOT NULL,
  user_id       char(36)      COLLATE utf8_unicode_ci NOT NULL,
  location_id   char(36)      COLLATE utf8_unicode_ci NULL, -- watch lists can be specific to a location
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

SET foreign_key_checks = 1;
