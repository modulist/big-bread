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

/** IMPORT EXISTING INCENTIVES DATA */

/**
 * Execute the local incentives database export. There are a few
 * dependencies, so this script must be executed first.
 */

SOURCE fp_incentive.sql;

/** A few adjustments to the incentives database */
ALTER TABLE us_states
  ENGINE = InnoDB,
  CONVERT TO CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';

ALTER TABLE us_zipcode
  MODIFY zip char(5) NOT NULL,
  ENGINE = InnoDB,
  CONVERT TO CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
  
UPDATE us_zipcode
  SET zip = LPAD(zip, 5, '0');


/** LOOKUP TABLES */

DROP TABLE IF EXISTS appliance_types;
CREATE TABLE appliance_types(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO appliance_types( id, code, name )
VALUES
( '4d7173d6-1294-434d-bd3c-4bf33b196446', 'WASHER', 'Washer' ),
( '4d7173d6-6a78-499a-ad62-4bf33b196446', 'DRYER', 'Dryer' ),
( '4d7173d6-b708-4a8b-b518-4bf33b196446', 'FREEZR', 'Freezer' ),
( '4d7173d6-0334-422d-a6b8-4bf33b196446', 'REFRIG', 'Refrigerator' ),
( '4d7173d6-4fc4-4c91-9a75-4bf33b196446', 'STOVE', 'Stove' ),
( '4d7173d6-9bf0-4389-b40c-4bf33b196446', 'OVEN', 'Oven' );

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
( '4d6ffa65-42e4-4322-86cf-7bcd3b196446', 'UNFNSH', 'Unfinished' ),
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

DROP TABLE IF EXISTS energy_sources;
CREATE TABLE energy_sources(
  id        char(36)      NOT NULL,
  code      varchar(6)    NOT NULL,
  name      varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO energy_sources( id, code, name )
VALUES
( '4d6ff444-1bd4-404f-bc53-7a073b196446', 'ELECT', 'Electric' ),
( '4d6ff444-7610-42bc-af05-7a073b196446', 'NATGAS', 'Natural Gas' ),
( '4d6ff444-c3cc-42c9-9d02-7a073b196446', 'OIL', 'Oil' ),
( '4d6ff444-1124-40a6-83eb-7a073b196446', 'PROPNE', 'Propane' );

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
( '4d700e7a-046c-4fa9-9655-82376e891b5e', 'ATTIC', 'Attic' ),
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

DROP TABLE IF EXISTS window_systems;
CREATE TABLE window_systems(
  id            char(36)      NOT NULL,
  code          varchar(6)    NOT NULL,
  name          varchar(255)  NOT NULL,
  deleted       boolean       NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

INSERT INTO window_systems( id, code, name )
VALUES
( '4d7167dc-37d8-4188-b73b-47ec3b196446', 'SINGLE', 'Single Pane' ),
( '4d7167dc-d1c0-45e9-b1e4-47ec3b196446', 'DOUBLE', 'Double Pane' ),
( '4d7167dc-56f4-4e01-945e-47ec3b196446', 'INSUL', 'Insulated Glass' ),
( '4d7167dc-cfa8-4b5c-82e2-47ec3b196446', 'CLEAR', 'Clear' ),
( '4d7167dc-4d0c-4628-a427-47ec3b196446', 'TINTED', 'Tinted' ),
( '4d7167dc-c2a0-423c-b566-47ec3b196446', 'LOWE', 'Low E' ),
( '4d7167dc-2c7c-4a6c-8a7c-47ec3b196446', 'ARGAS', 'Gas Filled (Ar)' ),
( '4d7167dc-939c-469b-b88c-47ec3b196446', 'WOOD', 'Wood' ),
( '4d7167dc-50ac-40e0-820a-47ec3b196446', 'VINYL', 'Vinyl' ),
( '4d7167dc-d1f8-4fc3-9a54-47ec3b196446', 'ALUMNM', 'Aluminum' );

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
  CONSTRAINT uix__email UNIQUE INDEX( email )
) ENGINE=InnoDB;

/** CORE BUILDING DATA */

DROP TABLE IF EXISTS addresses;
CREATE TABLE addresses(
  id        char(36)      NOT NULL,
  address_1 varchar(255)  NOT NULL,
  address_2 varchar(255)  NULL,
  city      varchar(255)  NOT NULL,
  state     char(2)       NOT NULL, -- TODO: Make char on both ends
  zip_code  char(5)       NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__addresses__us_states FOREIGN KEY( state )
    REFERENCES us_states( code )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT  fk__addresses__us_zipcode FOREIGN KEY( zip_code )
    REFERENCES us_zipcode( zip )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

DROP TABLE IF EXISTS buildings;
CREATE TABLE buildings(
  id                        char(36)  NOT NULL,
  -- associations
  building_type_id          char(36)  NULL,
  address_id                char(36)  NOT NULL,
  realtor_id                char(36)  NULL,
  inspector_id              char(36)  NOT NULL,
  client_id                 char(36)  NOT NULL,
  maintenance_level_id      char(36)  NULL,
  building_shape_id         char(36)  NULL,
  basement_type_id          char(36)  NULL,
  shading_type_id           char(36)  NULL,
  exposure_type_id          char(36)  NULL,
  insulation_level_id       char(36)  NULL,
  -- properties
  year_built                int       NULL,
  total_sf                  int       NULL,
  finished_sf               int       NULL,
  stories_above_ground      int       NULL,
  insulated_foundation      boolean   NULL,
  skylight_count            int       NULL,
  -- window-specific properties
  window_percent_average    float     NULL,
  window_percent_small      float     NULL,
  window_percent_large      float     NULL,
  window_wall               boolean   NULL DEFAULT 0,
  window_wall_sf            int       NULL,
  window_wall_side          char(1)   NULL,
  window_wall_ratio         float     NULL,
  -- infiltration properties
  drafts                    boolean   NOT NULL DEFAULT 0,
  visible_weather_stripping boolean   NULL,
  visible_caulking          boolean   NULL,
  windows_frequently_open   boolean   NULL,
  -- other stuff
  notes                     text      NULL,
  deleted                   boolean   NOT NULL DEFAULT 0,
  created                   datetime  NOT NULL,
  modified                  datetime  NOT NULL,
  
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
  CONSTRAINT fk__buildings__insulation_levels FOREIGN KEY( insulation_level_id )
    REFERENCES insulation_levels( id )
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

/** Appliance product catalog */
DROP TABLE IF EXISTS appliances;
CREATE TABLE appliances(
  id                char(36)      NOT NULL,
  appliance_type_id char(36)      NOT NULL,
  code              varchar(6)    NULL,
  energy_source_id  char(36)      NULL,
  make              varchar(255)  NULL,
  model             varchar(255)  NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__appliances__appliance_types FOREIGN KEY( appliance_type_id )
    REFERENCES appliance_types( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__appliances__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

/** Installed appliance info */
DROP TABLE IF EXISTS building_appliances;
CREATE TABLE building_appliances(
  id                char(36)      NOT NULL,
  building_id       char(36)      NOT NULL,
  appliance_id      char(36)      NOT NULL,
  year_built        int           NULL,
  serial_number     varchar(255)  NULL,
  efficiency_rating float         NULL,
  warranty_info     text          NULL,
  recall_info       text          NULL,
  notes             text          NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_appliances__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_appliances__appliances FOREIGN KEY( appliance_id )
    REFERENCES appliances( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

/** Hot water system product catalog */
DROP TABLE IF EXISTS hot_water_systems;
CREATE TABLE hot_water_systems(
  id                char(36)      NOT NULL,
  code              varchar(6)    NULL,
  energy_source_id  char(36)      NULL,
  make              varchar(255)  NULL,
  model             varchar(255)  NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__hot_water_systems__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

/** Installed hot water system info */
DROP TABLE IF EXISTS building_hot_water_sytems;
CREATE TABLE building_hot_water_systems(
  id                    char(36)      NOT NULL,
  building_id           char(36)      NOT NULL,
  hot_water_system_id   char(36)      NOT NULL,
  serial_number         varchar(255)  NULL,
  efficiency_rating     float         NULL,
  warranty_info         text          NULL,
  recall_info           text          NULL,
  notes                 text          NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_hot_water_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_hot_water_systems__hot_water_systems FOREIGN KEY( hot_water_system_id )
    REFERENCES hot_water_systems( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

/** HVAC system product catalog */
DROP TABLE IF EXISTS hvac_systems;
CREATE TABLE hvac_systems(
  id                  char(36)      NOT NULL,
  code                varchar(6)    NULL,
  energy_source_id    char(36)      NULL,
  make                varchar(255)  NULL,
  model               varchar(255)  NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__hvac_systems__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT uix__code UNIQUE INDEX( code )
) ENGINE=InnoDB;

/** Installed HVAC system info */
DROP TABLE IF EXISTS building_hvac_systems;
CREATE TABLE building_hvac_systems(
  id                char(36)      NOT NULL,
  building_id       char(36)      NOT NULL,
  hvac_system_id    char(36)      NOT NULL,
  serial_number     varchar(255)  NOT NULL,
  year_built        int           NOT NULL,
  setpoint_heating  int           NULL,
  setpoint_cooling  int           NULL,
  efficiency_rating float         NULL,
  warranty_info     text          NULL,
  recall_info       text          NULL,
  notes             text          NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_hvac_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_hvac_systems__hvac_systems FOREIGN KEY( hvac_system_id )
    REFERENCES hvac_systems( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;


DROP TABLE IF EXISTS building_roof_systems;
CREATE TABLE building_roof_systems(
  id                    char(36)    NOT NULL,
  building_id           char(36)    NOT NULL,
  roof_system_id        char(36)    NOT NULL,
  insulation_level_id   char(36)    NULL,
  living_space_ratio    float       NULL,
  radiant_barrier       boolean     NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_roof_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_roof_systems__roof_systems FOREIGN KEY( roof_system_id )
    REFERENCES roof_systems( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__building_roof_systems__insulation_levels FOREIGN KEY( insulation_level_id )
    REFERENCES insulation_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

DROP TABLE IF EXISTS building_wall_systems;
CREATE TABLE building_wall_systems(
  id                  char(36)  NOT NULL,
  building_id         char(36)  NOT NULL,
  wall_system_id      char(36)  NOT NULL,
  insulation_level_id char(36)  NULL,
  
  PRIMARY KEY( building_id, wall_system_id ),
  CONSTRAINT fk__building_wall_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_wall_systems__wall_systems FOREIGN KEY( wall_system_id )
    REFERENCES wall_systems( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT fk__building_wall_systems__insulation_levels FOREIGN KEY( insulation_level_id )
    REFERENCES insulation_levels( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

/** Not sure how to handle this */
DROP TABLE IF EXISTS building_window_systems;
CREATE TABLE building_window_systems(
  id                char(36)  NOT NULL,
  building_id       char(36)  NOT NULL,
  window_system_id  char(36)  NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_window_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_window_systems__window_systems FOREIGN KEY( window_system_id )
    REFERENCES window_systems( id )
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

/** SURVEYS */

/** Inspector questionnaires */
/** @todo Change nomenclature to "questionnaire" */
DROP TABLE IF EXISTS surveys;
CREATE TABLE surveys(
  id            char(36)    NOT NULL,
  building_id   char(36)    NULL,
  created       datetime    NOT NULL,
  modified      datetime    NOT NULL,
  deleted       boolean     NOT NULL DEFAULT 0,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__surveys__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

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
