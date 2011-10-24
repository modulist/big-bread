USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS questionnaires;

DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
  id                  char(36)      NOT NULL,
  message_template_id char(36)      NOT NULL,
  model               varchar(255)  NOT NULL, -- what generated the message?
  foreign_key         char(36)      NOT NULL, -- which of that what generated the message?
  sender_id           char(36)      COLLATE utf8_unicode_ci NULL, -- null if system is sender
  recipient_id        char(36)      COLLATE utf8_unicode_ci NOT NULL,
  replacements        text          NULL, -- JSON encoded string of variable replacement values
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
  code        varchar(255)  NOT NULL,
  type        varchar(255)  NOT NULL DEFAULT 'EMAIL',
  subject     varchar(255)  NULL,
  body_text   text          NOT NULL,
  body_html   text          NOT NULL,
  created     datetime      NOT NULL,
  modified    datetime      NOT NULL,
  
  PRIMARY KEY( id )
) ENGINE=InnoDB;

INSERT INTO message_templates( id, code, subject, body_text, body_html, created, modified )
VALUES
  ( UUID(), 'new_user', 'Thanks for registering to Save Big Bread at SaveBigBread.com',
    'Hi, %Recipient.first_name%. Welcome to SaveBigBread.com - your free and easy way to save on home improvement. Saving money is hard so we want to make it a virtual no-brainer to find rebates that apply to you, connect you with contractors authorized by program sponsors and finish the paperwork that gets you a check. 

Please send me an email if you need any help or if you have an idea on how we can improve our service. We''re always looking for a better way to make Saving Big Bread easier.

Regards,
Tony Maull, President 

P.S. I''d appreciate it if you would pass us along to your friends if you think they would like to Save Big Bread with you.',
    '<p>Hi, %Recipient.first_name%. Welcome to SaveBigBread.com - your free and easy way to save on home improvement. Saving money is hard so we want to make it a virtual no-brainer to find rebates that apply to you, connect you with contractors authorized by program sponsors and finish the paperwork that gets you a check. </p>
<p>Please send me an email if you need any help or if you have an idea on how we can improve our service. We''re always looking for a better way to make Saving Big Bread easier.</p>
<p>Regards,<br />
Tony Maull, President </p>
<p>P.S. I''d appreciate it if you would pass us along to your friends if you think they would like to Save Big Bread with you.</p>',
    NOW(), NOW()
  ),
  (
    UUID(), 'proposal_request', '%Sender.full_name% requests a quote from a qualified contractor.',
    'Please contact me to prepare an estimate for the following services:
    
Scope of Work
-------------------------------------------------------------------------------
%Proposal.scope_of_work%

Contact Information
-------------------------------------------------------------------------------
%Location.address_1%
%Location.address_2%
%Location.city%, %Location.state% %Location.zip_code%

%Sender.phone_number%
%Sender.email%

Contractor is responsible for reserving rebate funds with the program sponsor.

%Proposal.under_warranty%
%Proposal.permission_to_examine%

Existing Equipment
-------------------------------------------------------------------------------
%Fixture.existing%

Customer Notes
-------------------------------------------------------------------------------
%Proposal.notes%

Quoted Incentive
-------------------------------------------------------------------------------
%TechnologyIncentive.details%

Stacked Incentives
-------------------------------------------------------------------------------
%TechnologyIncentive.stack%
    ',
    '<h1>Please contact me to prepare an estimate for the following services:</h1>
    
<h2>Scope of Work</h2>
<hr />
<p>%Proposal.scope_of_work%</p>

<h2>Contact Information</h2>
<hr />
<p>%Location.address_1%<br />
%Location.address_2%<br />
%Location.city%, %Location.state% %Location.zip_code%</p>

<p>%Sender.phone_number%<br />
%Sender.email%</p>

<p>Contractor is responsible for reserving rebate funds with the program sponsor.</p>

<p>%Proposal.under_warranty%<br />
%Proposal.permission_to_examine%</p>

<h2>Existing Equipment</h2>
<hr />
%Fixture.existing%

<h2>Customer Notes</h2>
<hr />
<p>%Proposal.notes%</p>

<h2>Quoted Incentive</h2>
<hr />
%TechnologyIncentive.details%

<h2>Stacked Incentives</h2>
<hr />
%TechnologyIncentive.stack%',
    NOW(), NOW()
  )
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
 
SET foreign_key_checks = 1;
