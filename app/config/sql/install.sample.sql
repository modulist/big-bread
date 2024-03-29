/**
 * Installs the big bread database that supports the inspector's survey.
 * A complete database installation includes:
 *  - The latest dump of the fp_incentives database
 *  - Execution of Cake's session.sql DDL
 */

DROP DATABASE IF EXISTS @DB_NAME@;

CREATE DATABASE @DB_NAME@
  DEFAULT CHARACTER SET 'utf8'
  DEFAULT COLLATE 'utf8_unicode_ci';

-- GRANT ALL ON @DB_NAME@.* to @DB_NAME@_@DB_USERNAME@ IDENTIFIED BY '@DB_PASSWORD@';
-- GRANT ALL ON @DB_NAME@.* to @DB_NAME@_@DB_USERNAME@@localhost IDENTIFIED BY '@DB_PASSWORD@';
 
USE @DB_NAME@;

ALTER DATABASE @DB_NAME@ DEFAULT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';

/** IMPORT EXISTING INCENTIVES DATA */

/**
 * Execute the local incentives database export. There are a few
 * dependencies, so this script must be executed first.
 */

SOURCE fp_incentive.sql;

SET foreign_key_checks = 0; -- Protect against bad legacy data

/**
 * Convert everything in the schema to a unified collation. It looks like
 * this probably isn't necessary any longer, but it doesn't hurt, so I'm
 * going to go ahead and leave it in there.
 */
 
-- Cruft removal
DROP TABLE IF EXISTS incentive_tech__incentive_tech_energy_group; -- redundant, obsolete
DROP TABLE IF EXISTS dsireincentive;
DROP TABLE IF EXISTS dsireincentive_detail;
DROP TABLE IF EXISTS dsireincentive_dsireincentive_detail;
DROP TABLE IF EXISTS error_log_bak;

ALTER TABLE incentive
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive__incentive_tech
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_amount_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_county
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_note
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_note_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_energy
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_energy_group
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_energy_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_group
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_option
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_option_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_term
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_tech_term_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_type_group
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_utility
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_weblink
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_weblink_type
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_weblink_verification
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_zip
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE us_county
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE us_county__us_zipcode
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE us_states
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE us_zipcode
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE incentive_user
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE utility
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE utility_zip
  CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/** A few adjustments to the incentives database */

/**
 * Update key entities to remove double underscores.
 * - These created havoc with the framework
 * - Going to improve clarity as long as we're here.
 */
 
/**
 * INCENTIVES
 */

-- Prepare for a new PK field
ALTER TABLE incentive
  DROP PRIMARY KEY,
  ADD COLUMN id char(36) NULL FIRST,
  MODIFY COLUMN incentive_id varchar(10) NULL;

-- Populate the new incentive.id
UPDATE incentive
   SET id = UUID();
   
-- Reassign the PK and create a unique index on the old PK
ALTER TABLE incentive
  MODIFY id char(36) NOT NULL,
  ADD PRIMARY KEY( id ),
  ADD CONSTRAINT uix__incentive_id UNIQUE INDEX( incentive_id );
  
-- Minor data cleanup
UPDATE incentive
   SET expiration_date = null
 WHERE expiration_date = '0000-00-00';

    /**
     * TABLES ASSOCIATED WITH incentive
     * - Change the foreign key field to char(36)
     * - Update the appropriate records
     * - Create an actual foreign key
     */

    -- NOTES
    ALTER TABLE incentive_note
      MODIFY COLUMN incentive_id char(36) NOT NULL;
      
    UPDATE incentive_note, incentive
       SET incentive_note.incentive_id = incentive.id
     WHERE incentive_note.incentive_id = incentive.incentive_id;
     
    ALTER TABLE incentive_note
      ADD CONSTRAINT fk__incentive_note__incentive FOREIGN KEY( incentive_id )
        REFERENCES incentive( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;

    -- UTILITIES
    ALTER TABLE incentive_utility
      MODIFY COLUMN incentive_id char(36) NOT NULL;
      
    UPDATE incentive_utility, incentive
       SET incentive_utility.incentive_id = incentive.id
     WHERE incentive_utility.incentive_id = incentive.incentive_id;
     
    ALTER TABLE incentive_utility
      ADD CONSTRAINT fk__incentive_utility__incentive FOREIGN KEY( incentive_id )
        REFERENCES incentive( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;

    -- INCENTIVE_WEBLINK
    ALTER TABLE incentive_weblink
      MODIFY COLUMN incentive_id char(36) NOT NULL;
      
    UPDATE incentive_weblink, incentive
       SET incentive_weblink.incentive_id = incentive.id
     WHERE incentive_weblink.incentive_id = incentive.incentive_id;
     
    ALTER TABLE incentive_weblink
      ADD CONSTRAINT fk__incentive_weblink__incentive FOREIGN KEY( incentive_id )
        REFERENCES incentive( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;

    -- INCENTIVE_ZIPS
    ALTER TABLE incentive_zips
      MODIFY COLUMN incentive_id char(36) NOT NULL;
      
    -- Set the new technology_incentives.incentive_id value to the UUID, where appropriate
    UPDATE incentive_zips, incentive
       SET incentive_zips.incentive_id = incentive.id
     WHERE incentive_zips.incentive_id = incentive.incentive_id;
     
    -- Create real foreign keys
    ALTER TABLE incentive_zips
      ADD CONSTRAINT fk__incentive_zips__incentive FOREIGN KEY( incentive_id )
        REFERENCES incentive( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION,
      ADD CONSTRAINT fk__incentive_zips__us_zipcode FOREIGN KEY( zip )
        REFERENCES us_zipcode( zip )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;
          
    -- INCENTIVE_AMOUNT_TYPE
    ALTER TABLE incentive_amount_type
      RENAME TO incentive_amount_types;
      
    -- Prepare for a new PK field
    ALTER TABLE incentive_amount_types
      DROP PRIMARY KEY,
      ADD COLUMN id char(36) NULL FIRST,
      MODIFY COLUMN incentive_amount_type_id varchar(6) NULL;
      
    -- Populate the new incentive.id
    UPDATE incentive_amount_types
       SET id = UUID();
       
    -- Reassign the PK and create a unique index on the old PK
    ALTER TABLE incentive_amount_types
      MODIFY id char(36) NOT NULL,
      ADD PRIMARY KEY( id ),
      ADD CONSTRAINT uix__incentive_amount_type_id UNIQUE INDEX( incentive_amount_type_id );

/**
 * TECHNOLOGY GROUP
 */
 
ALTER TABLE incentive_tech_group
  RENAME TO technology_groups;
  
-- Prepare for a new PK field
ALTER TABLE technology_groups
  DROP PRIMARY KEY,
  ADD COLUMN id char(36) NULL FIRST,
  ADD COLUMN title varchar(255) NULL AFTER name,
  ADD COLUMN rebate_bar boolean NOT NULL DEFAULT 0
  MODIFY COLUMN incentive_tech_group_id varchar(6) NULL; -- whether this piece of tech is represented by a product on the questionnaire
  
-- Populate the new incentive.id
UPDATE technology_groups
   SET id = UUID();
   
-- Reassign the PK and create a unique index on the old PK
ALTER TABLE technology_groups
  MODIFY id char(36) NOT NULL,
  ADD PRIMARY KEY( id ),
  ADD CONSTRAINT uix__incentive_tech_group_id UNIQUE INDEX( incentive_tech_group_id );

UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Appliances'
 WHERE incentive_tech_group_id = 'APP';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Building Shell'
 WHERE incentive_tech_group_id = 'ENV';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Heating & Cooling'
 WHERE incentive_tech_group_id = 'HVAC';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Hot Water'
 WHERE incentive_tech_group_id = 'HW';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Lighting'
 WHERE incentive_tech_group_id = 'LIGHT';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Whole House'
 WHERE incentive_tech_group_id = 'WHOLE';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Other'
 WHERE incentive_tech_group_id = 'OTH';
 
/**
 * TECHNOLOGIES
 */
 
-- Rename the table for clarity as long as we're changing other stuff.
ALTER TABLE incentive_tech
  RENAME TO technologies;
  
-- Prepare for a new PK field
-- Adjust for changes to the technology_groups table above
-- Add a field
ALTER TABLE technologies
  DROP PRIMARY KEY,
  ADD COLUMN id char(36) NULL FIRST,
  MODIFY COLUMN incentive_tech_id varchar(10) NULL,
  CHANGE COLUMN incentive_tech_group_id technology_group_id char(36) NOT NULL,
  ADD COLUMN questionnaire_product boolean NOT NULL DEFAULT 0; -- whether this piece of tech is represented by a product on the questionnaire
  
-- Populate the new incentive.id
UPDATE technologies
   SET id = UUID();
   
-- Update group association data
UPDATE technologies, technology_groups
   SET technologies.technology_group_id = technology_groups.id
 WHERE technologies.technology_group_id = technology_groups.incentive_tech_group_id;
   
-- Reassign the PK and create a unique index on the old PK
ALTER TABLE technologies
  MODIFY id char(36) NOT NULL,
  ADD PRIMARY KEY( id ),
  ADD CONSTRAINT uix__incentive_tech_id UNIQUE INDEX( incentive_tech_id );

-- Identify the technology products we care about:
-- Boiler, AC, Dishwasher, Dryer, Freezer, Furnace, Heat Pump, Refrigerator,
-- Room AC, Space Heater, Washer, Water Heater, Range/Cooktop
UPDATE technologies
   SET questionnaire_product = 1
 WHERE incentive_tech_id IN ( 'BOIL','CAC','DISHW','DRYER','FREEZ','FURN','HP', 'RFRG', 'RMAC','SPHEAT','WASH','WH','COOK' );
     
UPDATE technologies
   SET name = 'Range/Cooktop/Oven'
 WHERE incentive_tech_id = 'COOK';
 

    /**
     * TABLES ASSOCIATED WITH technologies (nee incentive_tech)
     * - Change the foreign key field to char(36)
     * - Update the appropriate records
     * - Create an actual foreign key
     */

    -- Energy source
    ALTER TABLE incentive_tech_energy_type
      CHANGE COLUMN incentive_tech_id technology_id char(36) NOT NULL;
      
    -- Set the new incentive_tech_energy_type.technology_id value to the UUID, where appropriate
    UPDATE incentive_tech_energy_type, technologies
       SET incentive_tech_energy_type.technology_id = technologies.id
     WHERE incentive_tech_energy_type.technology_id = technologies.incentive_tech_id;

/**
 * TECHNOLOGY-INCENTIVE JOIN
 */
 
-- Rename to remove double underscore
-- Adjust for new foreign key fields
ALTER TABLE incentive__incentive_tech
  RENAME TO technology_incentives,
  CHANGE COLUMN incentive_tech_id technology_id char(36) NOT NULL,
  MODIFY incentive_amount_type_id char(36) NULL,
  MODIFY COLUMN incentive_id char(36) NOT NULL;
  
-- Set the new technology_incentives.incentive_id value to the UUID, where appropriate
UPDATE technology_incentives, incentive
   SET technology_incentives.incentive_id = incentive.id
 WHERE technology_incentives.incentive_id = incentive.incentive_id;
 
-- Set the new technology_incentives.incentive_tech_id value to the UUID, where appropriate
UPDATE technology_incentives, technologies
   SET technology_incentives.technology_id = technologies.id
 WHERE technology_incentives.technology_id = technologies.incentive_tech_id;
 
-- Create real foreign keys
ALTER TABLE technology_incentives
  ADD CONSTRAINT fk__technology_incentives__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION,
  ADD CONSTRAINT fk__technology_incentives__incentive FOREIGN KEY( incentive_id )
    REFERENCES incentive( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;

UPDATE technology_incentives, incentive_amount_types
   SET technology_incentives.incentive_amount_type_id = incentive_amount_types.id
 WHERE technology_incentives.incentive_amount_type_id = incentive_amount_types.incentive_amount_type_id;
 
ALTER TABLE technology_incentives
  ADD CONSTRAINT fk__technology_incentives__incentive_amount_types FOREIGN KEY( incentive_amount_type_id )
    REFERENCES incentive_amount_types( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;

    /**
     * TABLES ASSOCIATED WITH technology_incentives (nee incentive__incentive_tech)
     * - Change the foreign key field to char(36)
     * - Create an actual foreign key
     */

    -- Update foreign key fields to remove double underscore (incentive__incentive_tech_id)
    -- and to better fit framework conventions as long as a change has to be made.
    ALTER TABLE incentive_tech_energy
      CHANGE incentive__incentive_tech_id technology_incentive_id bigint NOT NULL,
      ADD CONSTRAINT fk__incentive_tech_energy__technology_incentives FOREIGN KEY( technology_incentive_id )
        REFERENCES technology_incentives( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;
          
    ALTER TABLE incentive_tech_option
      CHANGE incentive__incentive_tech_id technology_incentive_id bigint NOT NULL,
      ADD CONSTRAINT fk__incentive_tech_option__technology_incentives FOREIGN KEY( technology_incentive_id )
        REFERENCES technology_incentives( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;
          
    ALTER TABLE incentive_tech_term
      CHANGE incentive__incentive_tech_id technology_incentive_id bigint NOT NULL,
      ADD CONSTRAINT fk__incentive_tech_term__technology_incentives FOREIGN KEY( technology_incentive_id )
        REFERENCES technology_incentives( id )
          ON UPDATE CASCADE
          ON DELETE NO ACTION;

/**
 * Update the foreign key value on a few tables that aren't handled in
 * more detail below. These are tables that the new app doesn't use or
 * uses very little right now.
 */

/** ENERGY GROUP */

-- Drop existing key to prepare for a new id key
-- Add unique index where there was a primary key
ALTER TABLE incentive_tech_energy_group
  DROP COLUMN parent_id;
  
-- We're flattening this table so we can kill a couple of "parent" records
DELETE FROM incentive_tech_energy_group
      WHERE incentive_tech_energy_group_id IN ( 'GAS', 'ALT' );
/** ZIP CODE */

-- Required to create foreign key constraints
ALTER TABLE us_zipcode
  MODIFY zip char(5) NOT NULL;
  
-- Creates a ready-to-use value
UPDATE us_zipcode
  SET zip = LPAD(zip, 5, '0');
 
/** INCENTIVE-ZIPCODE JOIN */

-- Make the table join-ready
ALTER TABLE incentive_zip
  MODIFY zip char(5) NOT NULL;

-- Create a ready-to use zipcode value
UPDATE incentive_zip
   SET zip = LPAD(zip, 5, '0');

-- Foreign key
ALTER TABLE incentive_zip
  ADD CONSTRAINT fk__incentive_zip__us_zipcode FOREIGN KEY( zip )
    REFERENCES us_zipcode( zip )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;

/** UTILITY */

-- Add a UUID field that will become the primary key
-- Add a couple of fields so we can accept (and vet) new user input
-- Accept foreign key constraints
-- Autoincrement start value required to prevent entire table from resequencing
ALTER TABLE utility
  DROP PRIMARY KEY,
  ADD COLUMN id char(36) NULL FIRST,
  CHANGE COLUMN utility name varchar(255) NOT NULL,
  MODIFY COLUMN utility_id int NULL, -- nullable to avoid future conflicts when importing libraries.
  ADD COLUMN created datetime NULL AFTER name,
  ADD COLUMN reviewed boolean NULL DEFAULT 0 AFTER name,
  ADD COLUMN source varchar(255) NULL AFTER name;

-- Add an id (UUID) for easy access and manipulation
-- Set the source for existing records
-- Mark existing records as reviewed
UPDATE utility
   SET id = UUID(),
       source   = 'Platts',
       reviewed = 1;
       
ALTER TABLE utility
  MODIFY id char(36) NOT NULL,
  ADD PRIMARY KEY( id );

/** UTILITY-ZIPCODE JOIN */
      
-- Prepare utility_zip to use the UUID value as its foreign key to utility
ALTER TABLE utility_zip
  MODIFY COLUMN utility_id char(36) NULL,
  ADD COLUMN created datetime NULL AFTER type,
  ADD COLUMN reviewed boolean NULL DEFAULT 0 AFTER type,
  ADD COLUMN source varchar(255) NULL AFTER type;

-- Set the new utility_zip.utility_id value to the UUID, where appropriate
UPDATE utility_zip, utility
   SET utility_zip.utility_id = utility.id
 WHERE utility_zip.utility_id = utility.utility_id;

-- For all existing records, set the source and reviewed values
UPDATE utility_zip
   SET zip      = LPAD(zip, 5, '0'),
       source   = 'Platts',
       reviewed = 1;
 
-- Create an actual foreign key constraints
ALTER TABLE utility_zip
  ADD CONSTRAINT fk__utility_zip__utility FOREIGN KEY( utility_id )
    REFERENCES utility( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION,
  ADD CONSTRAINT fk__utility_zip__us_zipcode FOREIGN KEY( zip )
    REFERENCES us_zipcode( zip )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;

/** INCENTIVE-UTILITY JOIN */

-- Join table needs the new utility id
ALTER TABLE incentive_utility
  MODIFY COLUMN utility_id char(36) NOT NULL;

-- Set the new utility_zip.utility_id value to the UUID, where appropriate
UPDATE incentive_utility, utility
   SET incentive_utility.utility_id = utility.id
 WHERE incentive_utility.utility_id = utility.utility_id;
 
-- Create an actual foreign key constraints
ALTER TABLE incentive_utility
  ADD CONSTRAINT fk__incentive_utility__utility FOREIGN KEY( utility_id )
    REFERENCES utility( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;

SET foreign_key_checks = 1; -- Re-engage foreign key constraints

/** LOOKUP TABLES */

DROP TABLE IF EXISTS basement_types;
CREATE TABLE basement_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO basement_types( id, code, name )
VALUES
( '4d6ffa65-50b4-40de-9eff-7bcd3b196446', 'SLAB', 'Slab on Grade' ),
( '4d6ffa65-a960-4d5c-a5aa-7bcd3b196446', 'VCRWSP', 'Vented Crawlspace' ),
( '4d6ffa65-f654-4c75-a964-7bcd3b196446', 'SCRWSP', 'Sealed Crawlspace' ),
( '4d6ffa65-42e4-4322-86cf-7bcd3b196446', 'UNCOND', 'Unconditioned' ),
( '4d6ffa65-8f10-489d-8659-7bcd3b196446', 'CONDTN', 'Conditioned' );

DROP TABLE IF EXISTS building_shapes;
CREATE TABLE building_shapes(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO building_shapes( id, code, name )
VALUES
( '4d6ff444-5e18-4ca2-9386-7a073b196446', 'SQUARE', 'Square' ),
( '4d6ff444-ab70-43bb-8807-7a073b196446', 'RECT', 'Rectangular' ),
( '4d6ff444-f864-4668-b9b0-7a073b196446', 'LONG', 'Long' ),
( '4d6ff444-45bc-4aa4-b687-7a073b196446', 'LFORM', 'L-Form' ),
( '4d6ff444-9314-4058-8979-7a073b196446', 'UFORM', 'U-Form' ),
( '4d6ff444-e008-47a2-a98e-7a073b196446', 'OTHER', 'Other' );

DROP TABLE IF EXISTS building_types;
CREATE TABLE building_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO building_types( id, code, name )
VALUES
( '4d6ff15d-c9d0-4d44-9379-793d3b196446', 'SNGLFM', 'Single Family' ),
( '4d6ff15d-16c4-415f-92f8-793d3b196446', 'TWNHSE', 'Townhouse' );

DROP TABLE IF EXISTS exposure_types;
CREATE TABLE exposure_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO exposure_types( id, code, name )
VALUES
( '4d6ff15d-878c-4faf-b5f4-793d3b196446', 'OPEN', 'Open' ),
( '4d6ff15d-e100-489f-8016-793d3b196446', 'BLDGS', 'Other Buildings' ),
( '4d6ff15d-2f20-4f51-9a39-793d3b196446', 'TREES', 'Some trees' ),
( '4d6ff15d-7c14-49a2-ba4b-793d3b196446', 'WOODED', 'Wooded lot' );

DROP TABLE IF EXISTS insulation_levels;
CREATE TABLE insulation_levels(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO insulation_levels( id, code, name )
VALUES
( '4d700e7a-e0a8-477a-8b71-82376e891b5e', 'NONE', 'None' ),
( '4d700e7a-6fa0-4aee-acdc-82376e891b5e', 'POOR', 'Poor (3-6")' ),
( '4d700e7a-f088-46d3-8336-82376e891b5e', 'AVG', 'Average (7-10")' ),
( '4d700e7a-6108-44cf-9fe4-82376e891b5e', 'GOOD', 'Good (11-15")' ),
( '4d700e7a-d250-4c50-9a4f-82376e891b5e', 'NOSAY', 'Can''t Say' );

DROP TABLE IF EXISTS maintenance_levels;
CREATE TABLE maintenance_levels(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO maintenance_levels( id, code, name )
VALUES
( '4d6ff15d-63b8-4499-a6cd-793d3b196446', 'POOR', 'Poor' ),
( '4d6ff15d-b0ac-4bb2-b550-793d3b196446', 'AVG', 'Average' ),
( '4d6ff15d-fe04-47db-8811-793d3b196446', 'GOOD', 'Good' ),
( '4d6ff15d-4b5c-41d3-9696-793d3b196446', 'UNKNWN', 'Can''t Say' );

DROP TABLE IF EXISTS materials;
CREATE TABLE materials(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO materials( id, code, name )
VALUES
( '4d6ff15d-63b8-4499-a6cd-793d3b196446', 'WOOD', 'Wood' ),
( '4d6ff15d-b0ac-4bb2-b550-793d3b196446', 'VINYL', 'Vinyl' ),
( '4d6ff15d-fe04-47db-8811-793d3b196446', 'ALUM', 'Aluminum' );


DROP TABLE IF EXISTS roof_systems;
CREATE TABLE roof_systems(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO roof_systems( id, code, name )
VALUES
( '4d700e7a-046c-4fa9-9655-82376e891b5e', 'UNFATT', 'Unfinished Attic' ),
( '4d77eeb6-d174-44e8-9997-99156e891b5e', 'FINATT', 'Finished Attic' ),
( '4d703e1f-aa00-4495-ba91-93086e891b5e', 'CTHDRL', 'Cathedral Ceilings' ),
( '4d703e1f-4960-403f-b3d7-93086e891b5e', 'FLAT', 'Flat Roof' );

DROP TABLE IF EXISTS shading_types;
CREATE TABLE shading_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO shading_types( id, code, name )
VALUES
( '4d700e7a-426c-4a28-a6dd-82376e891b5e', 'NONE', 'None' ),
( '4d700e7a-b2ec-4ead-a2e9-82376e891b5e', 'INTBLD', 'Interior Blinds' ),
( '4d700e7a-236c-4e0e-8a62-82376e891b5e', 'EXTBLD', 'Exterior Blinds/Overhangs' ),
( '4d700e7a-9388-411c-8c0a-82376e891b5e', 'SHADE', 'Shaded Lot (trees)' );

DROP TABLE IF EXISTS wall_systems;
CREATE TABLE wall_systems(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  u_value   float         NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO wall_systems( id, code, name )
VALUES
( '4d6ffa65-dba0-4594-8346-7bcd3b196446', 'TMBFRM', 'Timber Frame Masonry' ),
( '4d6ffa65-27cc-49b7-b5f5-7bcd3b196446', 'CONBLK', 'Concrete Block' ),
( '4d6ffa65-73f8-412e-ab8c-7bcd3b196446', 'OTHER', 'Other' );

DROP TABLE IF EXISTS window_pane_types;
CREATE TABLE window_pane_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO window_pane_types( id, code, name )
VALUES
( '4d6ffa65-dba0-4594-8346-7bcd3b196446', 'SINGLE', 'Single' ),
( '4d6ffa65-27cc-49b7-b5f5-7bcd3b196446', 'DOUBLE', 'Double' ),
( '4d6ffa65-73f8-412e-ab8c-7bcd3b196446', 'GAS', 'Gas Filled' );

/** APPLICATION USERS */

DROP TABLE IF EXISTS user_types;
CREATE TABLE user_types(
  id          char(36)        NOT NULL,
  code        varchar(6)      NULL,
  name        varchar(255)    NULL, -- e.g. Homeowner, Buyer, Realtor, Inspector, etc.
  deleted     boolean         NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO user_types( id, name )
VALUES
( '4d6d9699-f19c-41e3-a723-45ae6e891b5e', 'Realtor' ),
( '4d6d9699-5088-48db-9f56-47ea6e891b5e', 'Inspector' ),
( '4d6d9699-a7a4-42a1-855e-4f606e891b5e', 'Buyer' ),
( '4d71115d-0f74-43c5-93e9-2f8a3b196446', 'Homeowner' );

DROP TABLE IF EXISTS users;
CREATE TABLE users(
  id              char(36)        NOT NULL,
  user_type_id    char(36)        NOT NULL,
  first_name      varchar(255)    NOT NULL,
  last_name       varchar(255)    NOT NULL,
  email           varchar(255)    NOT NULL,
  phone_number    varchar(255)    NULL,
  invite_code     char(32)        NULL,     -- MD5 hash of a UUID (slightly prettier)
  password        varchar(255)    NULL,
  last_login      datetime        NULL,
  deleted         boolean         NOT NULL DEFAULT 0,
  created         datetime        NOT NULL,
  modified        datetime        NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__users__user_types FOREIGN KEY( user_type_id )
    REFERENCES user_types( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT uix__email UNIQUE INDEX( email ),
  CONSTRAINT uix__invite_code UNIQUE INDEX( invite_code )
) ENGINE=InnoDB;

/** CORE BUILDING DATA */

DROP TABLE IF EXISTS addresses;
CREATE TABLE addresses(
  id        char(36)      NOT NULL,
  address_1 varchar(255)  NOT NULL,
  address_2 varchar(255)  NULL,
  zip_code  char(5)       NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__addresses__us_zipcode FOREIGN KEY( zip_code )
    REFERENCES us_zipcode( zip )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

DROP TABLE IF EXISTS buildings;
CREATE TABLE buildings(
  id                        char(36)          NOT NULL,
  -- associations
  building_type_id          char(36)          NULL,
  address_id                char(36)          NOT NULL,
  realtor_id                char(36)          NULL,
  inspector_id              char(36)          NULL,
  client_id                 char(36)          NOT NULL,
  maintenance_level_id      char(36)          NULL,
  building_shape_id         char(36)          NULL,
  basement_type_id          char(36)          NULL,
  shading_type_id           char(36)          NULL,
  exposure_type_id          char(36)          NULL,
  insulation_level_id       char(36)          NULL,
  electricity_provider_id   char(36)          NULL,
  gas_provider_id           char(36)          NULL,
  water_provider_id         char(36)          NULL,
  other_heating_source      varchar(255)      NULL,
  -- properties
  year_built                int               NULL,
  total_sf                  int               NULL,
  finished_sf               int               NULL,
  stories_above_ground      int               NULL,
  insulated_foundation      boolean           NULL,
  skylight_count            int               NULL,
  -- hvac-specific properties
  setpoint_heating          int               NULL,
  setpoint_cooling          int               NULL,
  -- window-specific properties
  window_percent_average    float             NULL,
  window_percent_small      float             NULL,
  window_percent_large      float             NULL,
  window_wall               boolean           NULL DEFAULT 0,
  window_wall_sf            int               NULL,
  window_wall_side          char(1)           NULL,
  window_wall_ratio         float             NULL,
  -- infiltration properties
  drafts                    boolean           NOT NULL DEFAULT 0,
  visible_weather_stripping boolean           NULL,
  visible_caulking          boolean           NULL,
  windows_frequently_open   boolean           NULL,
  roof_insulation_level_id  boolean           NULL
  roof_radiant_barrier      boolean           NULL,
  -- other stuff
  notes                     text              NULL,
  deleted                   boolean           NOT NULL DEFAULT 0,
  created                   datetime          NOT NULL,
  modified                  datetime          NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings__building_types FOREIGN KEY( building_type_id )
    REFERENCES building_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__addresses FOREIGN KEY( address_id )
    REFERENCES addresses( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__buildings__realtor FOREIGN KEY( realtor_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__inspector FOREIGN KEY( inspector_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__buildings__client FOREIGN KEY( client_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__buildings__maintenance_levels FOREIGN KEY( maintenance_level_id )
    REFERENCES maintenance_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__building_shapes FOREIGN KEY( building_shape_id )
    REFERENCES building_shapes( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__basement_types FOREIGN KEY( basement_type_id )
    REFERENCES basement_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__shading_types FOREIGN KEY( shading_type_id )
    REFERENCES shading_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__exposure_types FOREIGN KEY( exposure_type_id )
    REFERENCES exposure_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__insulation_levels__insulation_level_id FOREIGN KEY( insulation_level_id )
    REFERENCES insulation_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__insulation_levels__roof_insulation_id FOREIGN KEY( roof_insulation_level_id )
    REFERENCES insulation_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
  CONSTRAINT fk__buildings__utility_ele FOREIGN KEY( electricity_provider_id )
    REFERENCES utility( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__utility__gas FOREIGN KEY( gas_provider_id )
    REFERENCES utility( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__utility__wtr FOREIGN KEY( water_provider_id )
    REFERENCES utility( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

/** Building occupancy info */
DROP TABLE IF EXISTS occupants;
CREATE TABLE occupants(
  id                    char(36)  NOT NULL,
  building_id           char(36)  NOT NULL,
  age_0_5               int       NULL,
  age_6_13              int       NULL,
  age_14_64             int       NULL,
  age_65                int       NULL,
  daytime_occupancy     boolean   NULL,
  heating_override      boolean   NULL,
  cooling_override      boolean   NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__occupants__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

/** PRODUCTS AND PRODUCT JOINS */

/**
 * A catalog of products we know about and are interested in.
 */
DROP TABLE IF EXISTS products;
CREATE TABLE products(
  id                char(36)      NOT NULL,
  technology_id     char(36)      NOT NULL,
  make              varchar(255)  NULL,
  model             varchar(255)  NULL,
  ahri_ref_number   varchar(255)  NULL, -- AHRI certified reference number (http://www.ahridirectory.org/ahridirectory/pages/home.aspx)
  energy_source_id  varchar(6)    NULL,
  efficiency_rating float         NULL,
  warranty_info     text          NULL,
  recall_info       text          NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__products__make_model_energy UNIQUE INDEX( make, model, energy_source_id ),
  CONSTRAINT fk__products__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__products__incentive_tech_energy_type FOREIGN KEY( energy_source_id )
    REFERENCES incentive_tech_energy_type( incentive_tech_energy_type_id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;
 
/** Installed appliance info */
DROP TABLE IF EXISTS building_products;
CREATE TABLE building_products(
  id                char(36)      NOT NULL,
  building_id       char(36)      NOT NULL,
  product_id        char(36)      NOT NULL,
  year_built        int           NULL,
  serial_number     varchar(255)  NULL,
  notes             text          NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__building_products__serial_number UNIQUE INDEX( serial_number ),
  CONSTRAINT fk__building_products__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_products__products FOREIGN KEY( product_id )
    REFERENCES products( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

DROP TABLE IF EXISTS building_roof_systems;
CREATE TABLE building_roof_systems(
  id                    char(36)    NOT NULL,
  building_id           char(36)    NOT NULL,
  roof_system_id        char(36)    NOT NULL,
  living_space_ratio    float       NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_roof_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_roof_systems__roof_systems FOREIGN KEY( roof_system_id )
    REFERENCES roof_systems( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

DROP TABLE IF EXISTS building_wall_systems;
CREATE TABLE building_wall_systems(
  id                  char(36)  NOT NULL,
  building_id         char(36)  NOT NULL,
  wall_system_id      char(36)  NULL,
  insulation_level_id char(36)  NULL,
  
  PRIMARY KEY( building_id, wall_system_id ),
  CONSTRAINT fk__building_wall_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__building_wall_systems__wall_systems FOREIGN KEY( wall_system_id )
    REFERENCES wall_systems( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__building_wall_systems__insulation_levels FOREIGN KEY( insulation_level_id )
    REFERENCES insulation_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

/** Not sure how to handle this */
DROP TABLE IF EXISTS building_window_systems;
CREATE TABLE building_window_systems(
  id                  char(36)  NOT NULL,
  building_id         char(36)  NOT NULL,
  window_pane_type_id char(36)  NULL,
  frame_material_id   char(36)  NULL,
  tinted              boolean   NOT NULL DEFAULT 0,
  low_e               boolean   NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_window_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_window_systems__window_pane_types FOREIGN KEY( window_pane_type_id )
    REFERENCES window_pane_types( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__building_window_systems__materials FOREIGN KEY( frame_material_id )
    REFERENCES materials( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

/** PARTNERS */

/** Partners authorized to access the survey remotely */
DROP TABLE IF EXISTS partners;
CREATE TABLE partners(
  id        char(36)      NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  created   datetime      NOT NULL,
  modified  datetime      NOT NULL,

  PRIMARY KEY( id )
) ENGINE=InnoDB;

INSERT INTO partners( id, name, created, modified )
VALUES( '4d6da23a-8fe0-407f-99c5-4d006e891b5e', 'Test Partner', NOW(), NOW() );

/** Domains from which to expect partner requests */
DROP TABLE IF EXISTS partner_domains;
CREATE TABLE partner_domains(
  id                char(36)      NOT NULL,
  partner_id        char(36)      NOT NULL,
  top_level_domain  varchar(255)  NOT NULL,
  created           datetime      NOT NULL,
  modified          datetime      NOT NULL,

  PRIMARY KEY( id ),
  CONSTRAINT  fk__partner_domains__partners FOREIGN KEY( partner_id )
    REFERENCES partners( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO partner_domains( id, partner_id, top_level_domain, created, modified )
VALUES( '4d6da23a-a5dc-470d-9238-43e76e891b5e', '4d6da23a-8fe0-407f-99c5-4d006e891b5e', 'partnersite.com', NOW(), NOW() );

/** Questionnaire */

DROP TABLE IF EXISTS questionnaires;
CREATE TABLE questionnaires(
  id            char(36)    NOT NULL,
  building_id   char(36)    NOT NULL,
  deleted       boolean     NOT NULL DEFAULT 0,
  created       datetime    NOT NULL,
  modified      datetime    NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__questionnaires__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

/** Glossary */

DROP TABLE IF EXISTS glossary_terms;
CREATE TABLE glossary_terms(
  id          char(36)      NOT NULL,
  foreign_key char(36)      NOT NULL,
  model       varchar(255)  NOT NULL,
  definition  varchar(255)  NOT NULL,
  active      boolean       NOT NULL DEFAULT 1,
  created     datetime      NULL,
  modified    datetime      NULL,
  
  PRIMARY KEY( id )
) ENGINE=InnoDB;

/** Tips */

DROP TABLE IF EXISTS tips;
CREATE TABLE tips(
  id          char(36)      NOT NULL,
  tip         varchar(255)  NOT NULL,
  active      boolean       NOT NULL DEFAULT 1,
  created     datetime      NULL,
  modified    datetime      NULL,
  
  PRIMARY KEY( id )
) ENGINE=InnoDB;

-- Support the auditable behavior
SOURCE auditable.sql;

/**
 * CAKEPHP SESSION STORAGE
 * From cake/console/templates/skel/config/schema
 */
CREATE TABLE cake_sessions(
  id      varchar(255) NOT NULL default '',
  data    text,
  expires int(11) default NULL,
  PRIMARY KEY( id )
);
