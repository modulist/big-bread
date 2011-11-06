USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

UPDATE incentive
   SET expiration_date = null
 WHERE expiration_date = '0000-00-00';

DROP TABLE IF EXISTS questionnaires;

DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
  id                  char(36)      NOT NULL,
  message_template_id char(36)      NOT NULL,
  model               varchar(255)  NULL, -- what generated the message? 
  foreign_key         char(36)      NULL, -- which of that what generated the message?
  sender_id           char(36)      COLLATE utf8_unicode_ci NULL COMMENT 'A null sender indicates a message from the system (e.g. new user email)', -- null if system is sender
  recipient_id        char(36)      COLLATE utf8_unicode_ci NULL COMMENT 'A null recipient indicates a message to the system (e.g. feedback)', -- null if sent to system
  replacements        mediumtext    NULL COMMENT 'JSON encoded string of variable replacement values',
  sent                datetime      NULL,
  created             datetime      NOT NULL,
  modified            datetime      NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__messages__message_templates FOREIGN KEY( message_template_id )
    REFERENCES message_templates( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION,
  CONSTRAINT fk__messages__senders FOREIGN KEY( sender_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__messages__recipients FOREIGN KEY( recipient_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS message_templates;
CREATE TABLE message_templates(
  id          char(36)      NOT NULL,
  template    varchar(255)  NOT NULL,
  type        varchar(255)  NOT NULL DEFAULT 'EMAIL',
  subject     varchar(255)  NULL,
  created     datetime      NOT NULL,
  modified    datetime      NOT NULL,
  
  PRIMARY KEY( id )
) ENGINE=InnoDB;

INSERT INTO message_templates( id, template, subject, created, modified )
VALUES
  ( UUID(), 'new_user', '%recipient_first_name%, thanks for registering to Save Big Bread on SaveBigBread.com', NOW(), NOW() ),
  ( UUID(), 'new_realtor', 'SaveBigBread creates referrals from happy clients.', NOW(), NOW() ),
  ( UUID(), 'new_inspector', 'SaveBigBread creates referrals from happy clients.', NOW(), NOW() ),
  ( UUID(), 'invite', '%recipient_first_name% wants you to save $1,000s on SaveBigBread', NOW(), NOW() ),
  ( UUID(), 'proposal_request', '%sender_full_name% requests a quote from a qualified contractor', NOW(), NOW() ),
  ( UUID(), 'forgot_password', 'Reset your SaveBigBread.com password', NOW(), NOW() ),
  ( UUID(), 'feedback', 'Feedback from a user at SaveBigBread.com', NOW(), NOW() ),
  ( UUID(), 'client_rebates', 'Selected rebates for your client, %client_name%.', NOW(), NOW() )
;

ALTER TABLE proposals
  DROP timing,
  DROP urgency,
  ADD location_id char(36) NULL AFTER technology_id,
  ADD permission_to_examine boolean NOT NULL DEFAULT 0 AFTER scope_of_work,
  ADD under_warranty boolean NOT NULL DEFAULT 0 AFTER scope_of_work,
  ADD technology_incentive_id bigint(20) NULL AFTER user_id,
  DROP FOREIGN KEY fk__proposals__incentive,
  DROP FOREIGN KEY fk__proposals__technologies,
  ADD CONSTRAINT fk__proposals__technology_incentives FOREIGN KEY( technology_incentive_id )
    REFERENCES technology_incentives( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION,
  ADD CONSTRAINT fk__proposals__buildings FOREIGN KEY( location_id )
    REFERENCES buildings( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;
 
UPDATE proposals p, technology_incentives ti
   SET p.technology_incentive_id = ti.id
 WHERE ti.technology_id = p.technology_id
       AND ti.incentive_id = p.incentive_id;
       
ALTER TABLE proposals
  DROP incentive_id,
  DROP technology_id;
 
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
  ADD year_installed    int           NULL AFTER service_in,
  ADD outside_unit      boolean       NOT NULL DEFAULT 0 AFTER serial_number;

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
  model         varchar(255)  NOT NULL,
  foreign_key   char(36)      COLLATE utf8_unicode_ci NOT NULL,
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
  CONSTRAINT uix_watch_lists UNIQUE INDEX( user_id, location_id, model, foreign_key )
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
  ADD name varchar(255) NULL AFTER id,
  ADD electricity_provider_account varchar(255) NULL AFTER electricity_provider_id,
  ADD gas_provider_account varchar(255) NULL AFTER gas_provider_id,
  ADD water_provider_account varchar(255) NULL AFTER water_provider_id;

ALTER TABLE technologies
  ADD CONSTRAINT fk__technologies__technology_groups FOREIGN KEY( technology_group_id )
    REFERENCES technology_groups( id )
    ON DELETE NO ACTION
    ON UPDATE CASCADE;

INSERT INTO technology_groups( id, incentive_tech_group_id, name, title, parent_group_id, rebate_bar )
VALUES
  ( '4e7a5b45-387c-4ef6-81bb-22536e891b5e', 'KTCH', 'Kitchen', 'Kitchen', null, 1 ),
  ( '4e7a5b45-6054-4f0c-b939-22536e891b5e', 'LNDR', 'Laundry', 'Laundry', null, 1 );

ALTER TABLE technology_groups
  DROP rebate_bar,
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
   SET title         = 'Energy Efficiency',
       display_order = 6
 WHERE incentive_tech_group_id = 'WHOLE';

UPDATE technology_groups
   SET display_order = null
 WHERE incentive_tech_group_id IN ( 'OTH','LIGHT' );
 
UPDATE technology_groups
   SET display_order = 99
 WHERE display_order IS NULL;

ALTER TABLE technologies
  DROP questionnaire_product,
  CHANGE display watchable boolean NOT NULL DEFAULT 0,
  MODIFY name varchar(255) NOT NULL,
  CHANGE dname title varchar(255) NULL,
  MODIFY description varchar(255) NULL;

UPDATE technologies
   SET technology_group_id = '4e7a5b45-387c-4ef6-81bb-22536e891b5e' -- Kitchen
 WHERE incentive_tech_id IN( 'COOK', 'DISHW', 'FREEZ', 'RFRG' );

UPDATE technologies
   SET technology_group_id = '4e7a5b45-6054-4f0c-b939-22536e891b5e' -- Laundry
 WHERE incentive_tech_id IN( 'WASH', 'DRYER' );

UPDATE technologies
   SET watchable = 1
 WHERE incentive_tech_id IN( 'AIRSL' );
 
UPDATE technologies
   SET watchable = 0
 WHERE incentive_tech_id IN( 'CEILF', 'CHP', 'CTRL', 'DHUM', 'DRHR', 'FIREPL', 'INS', 'LAMP', 'LFIX', 'LCTRL', 'MAINT', 'MOTOR', 'OTHER', 'POOLP', 'PSHEAT', 'PTHST', 'PV', 'RMAC', 'SHOWER', 'SIDING', 'SPHEAT', 'STEAM', 'WBLD', 'WHFAN', 'WHINS', 'WIND' );

UPDATE technologies
   SET name = 'Dishwashers'
 WHERE incentive_tech_id = 'DISHW';

UPDATE technologies
   SET title = name
 WHERE title IS NULL;

UPDATE technologies
   SET title = 'Central Air Conditioners'
 WHERE incentive_tech_id = 'CAC';

UPDATE technologies
   SET title = 'Tune-Ups',
       watchable = 1
 WHERE incentive_tech_id = 'MAINT';
 
UPDATE technologies
   SET watchable = 1
 WHERE incentive_tech_id = 'INS';
 
UPDATE technologies
   SET title = 'Glass Doors'
 WHERE incentive_tech_id = 'DOOR';
 
UPDATE technologies
   SET title = 'Roofing'
 WHERE incentive_tech_id = 'ROOF';
 
UPDATE technologies
   SET title     = 'Audit/Home Performance',
       watchable = 1
 WHERE incentive_tech_id = 'WBLD';
 
UPDATE technologies
   SET title = 'Heat Pumps'
 WHERE incentive_tech_id = 'HP';
 
UPDATE user_types
   SET selectable = 1
 WHERE code = 'CNTRCT';
 
ALTER TABLE contractors
  ADD licensed boolean NOT NULL DEFAULT 0 COMMENT 'Whether the contractor possesses all required state and local licenses.' AFTER better_business_bureau_listed,
  ADD felony_charges boolean NOT NULL DEFAULT 0 COMMENT 'Whether the contractor has any criminal or sex offender charges or convictions in his/her history.' AFTER better_business_bureau_listed,
  ADD filings_current boolean NOT NULL DEFAULT 0 COMMENT 'Whether the contractor is current in all of his/her state filings.' AFTER better_business_bureau_listed,
  ADD bankruptcy_filings boolean NOT NULL DEFAULT 0 COMMENT 'Whether the contractor has filed for bankruptcy or has any judgements or liens against him/her.' AFTER better_business_bureau_listed
;
 
SET foreign_key_checks = 1;
