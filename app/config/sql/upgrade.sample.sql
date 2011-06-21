USE @DB_NAME@;

SET NAMES utf8;
SET foreign_key_checks = 0;

-- Changes to support Contractor users
INSERT INTO user_types( id, code, name, selectable, deleted ) VALUES
  ( '6573bca8-945a-11e0-adec-3aadb68782f6', 'CNTRCT', 'Contractor', 1, 0 )
;

DROP TABLE IF EXISTS contractors;
CREATE TABLE contractors(
  id                  char(36)  NOT NULL,
  user_id             char(36)  NOT NULL,
  company_name        char(36)  NOT NULL,
  billing_address_id  char(36)  NOT NULL,
  certified_nate      boolean   NOT NULL DEFAULT 0,
  certified_bpi       boolean   NOT NULL DEFAULT 0,
  certified_resnet    boolean   NOT NULL DEFAULT 0,
  certified_other     text      NULL,
  created             datetime  NOT NULL,
  modified            datetime  NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__contractors__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__contractors__addresses FOREIGN KEY( billing_address_id )
    REFERENCES addresses( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Defines the territory in which a given contractor operates.
DROP TABLE IF EXISTS contractors_counties;
CREATE TABLE contractors_counties(
  contractor_id   char(36)  NOT NULL,
  county_id       smallint  NOT NULL,
  
  CONSTRAINT uix__contractor_id__county_id
    UNIQUE INDEX( contractor_id, county_id ),
  CONSTRAINT fk__contractors_counties__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__contractors_counties__us_county FOREIGN KEY( county_id )
    REFERENCES us_county( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Defines the technologies that a contractor services
DROP TABLE IF EXISTS contractors_technologies;
CREATE TABLE contractors_technologies(
  contractor_id   char(36)  NOT NULL,
  technology_id   char(36)  NOT NULL,
  
  CONSTRAINT uix__contractor_id__technology_id
    UNIQUE INDEX( contractor_id, technology_id ),
  CONSTRAINT fk__contractors_technologies__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__contractors_technologies__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Defines the manufacturers whose equipment a contractor services
-- and whether the contractor is certified for the manufacture's
-- incentive programs.
DROP TABLE IF EXISTS manufacturer_dealers;
CREATE TABLE manufacturer_dealers(
  id                        char(36)  NOT NULL,
  contractor_id             char(36)  NOT NULL,
  equipment_manufacturer_id char(36)  NOT NULL,
  incentive_participant     boolean   NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__contractor_id__equipment_manufacturer_id
    UNIQUE INDEX( contractor_id, equipment_manufacturer_id ),
  CONSTRAINT fk__manufacturer_dealers__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__manufacturer_dealers__equip_manuf FOREIGN KEY( equipment_manufacturer_id )
    REFERENCES equipment_manufacturers( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Defines the relationship between a contractor and utilities in the
-- areas s/he services. If a relationship exists, it's because the
-- contractor is incentive certified by that utility.
DROP TABLE IF EXISTS contractors_utilities;
CREATE TABLE contractors_utilities(
  contractor_id       char(36)  NOT NULL,
  utility_id          char(36)  NOT NULL,
  
  CONSTRAINT uix__contractor_id__utility_id
    UNIQUE INDEX( contractor_id, utility_id ),
  CONSTRAINT fk__contractors_utilities__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__contractors_utilities__utility FOREIGN KEY( utility_id )
    REFERENCES utility( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Creates the "helpful tips" data seen on the incentives page.
ALTER TABLE tips
  CHANGE tip text varchar(255) NOT NULL;
  
INSERT INTO tips( id, text, created, modified )
VALUES
  ( UUID(), 'As a minimum, combine the Federal Tax Credit with your state or utility rebate.', NOW(), NOW() ),
  ( UUID(), 'Check the rebate detail for possible rebate combinations that increase your savings.', NOW(), NOW() ),
  ( UUID(), 'You must be a customer of the utility in order to take advantage of the utility rebate.', NOW(), NOW() ),
  ( UUID(), 'In some cases, the utility offers electricity and natural gas service and you might have to be a customer of one or both in order to take the rebate.', NOW(), NOW() ),
  ( UUID(), 'Check with your contractor and see if they are certified by the utility to do the work.', NOW(), NOW() ),
  ( UUID(), 'See if your contractor will deduct the amount of the rebate from your bill if there is an option for them to manage the payment process for you.', NOW(), NOW() ),
  ( UUID(), 'The average homeowner spends $2,300 a year on the maintenance and repair of their home.', NOW(), NOW() ),
  ( UUID(), 'Send us notes through "feedback" on how we can improve this service.', NOW(), NOW() ),
  ( UUID(), 'We''ll let you know by email whether new rebates are introduced or current rebates are set to expire.', NOW(), NOW() ),
  ( UUID(), 'The average useful life of a furnace or an air conditioning unit is 15 years.  The average cost of replacement is $6,000.', NOW(), NOW() ),
  ( UUID(), 'The average life of a hot water heater is 12 years.  The average cost of replacement is $1,000 for a tank water heater.', NOW(), NOW() ),
  ( UUID(), 'The average life of kitchen appliances is 10 years.', NOW(), NOW() );

SET foreign_key_checks = 1;
