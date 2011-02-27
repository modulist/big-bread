/**
 * Installs the big bread database that supports the contractor survey.
 * A complete database installation includes:
 *  - The latest dump of the fp_incentives database
 *  - Execution of Cake's session.sql DDL
 */
 
DROP DATABASE IF EXISTS @DB_NAME@;
CREATE DATABASE @DB_NAME@
  DEFAULT CHARACTER SET 'utf8'
  DEFAULT COLLATE 'utf8_unicode_ci';

GRANT ALL ON @DB_NAME@.* to @DB_NAME@_@DB_USERNAME@ IDENTIFIED BY '@DB_PASSWORD@';
GRANT ALL ON @DB_NAME@.* to @DB_NAME@_@DB_USERNAME@@localhost IDENTIFIED BY '@DB_PASSWORD@';

USE @DB_NAME@;

/** LOOKUP TABLES */

CREATE TABLE building_types(
  id                char(36)      NOT NULL,
  building_type_id  varchar(6)    NOT NULL,
  name              varchar(255)  NOT NULL,
  deleted           boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__building_type_id UNIQUE INDEX( building_type_id )
)
ENGINE=InnoDB;

CREATE TABLE basement_types(
  id                char(36)      NOT NULL,
  basement_type_id  varchar(6)    NOT NULL,
  name              varchar(255)  NOT NULL,
  deleted           boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__basement_type_id UNIQUE INDEX( basement_type_id )
)
ENGINE=InnoDB;

CREATE TABLE shading_types(
  id                char(36)      NOT NULL,
  shading_type_id   varchar(6)    NOT NULL,
  name              varchar(255)  NOT NULL,
  deleted           boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__shading_type_id UNIQUE INDEX( shading_type_id )
)
ENGINE=InnoDB;

CREATE TABLE infiltration_types(
  id                    char(36)      NOT NULL,
  infiltration_type_id  varchar(6)    NOT NULL,
  name                  varchar(255)  NOT NULL,
  deleted               boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__infiltration_type_id UNIQUE INDEX( infiltration_type_id )
)
ENGINE=InnoDB;

CREATE TABLE exposure_types(
  id                char(36)      NOT NULL,
  exposure_type_id  varchar(6)    NOT NULL,
  name              varchar(255)  NOT NULL,
  deleted           boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__exposure_type_id UNIQUE INDEX( exposure_type_id )
)
ENGINE=InnoDB;

CREATE TABLE energy_sources(
  id                      char(36)      NOT NULL,
  energy_source_type_id   varchar(6)    NOT NULL,
  name                    varchar(255)  NOT NULL,
  deleted                 boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__energy_source_type_id UNIQUE INDEX( energy_source_type_id )
)
ENGINE=InnoDB;

CREATE TABLE materials(
  id                 char(36)      NOT NULL,
  material_type_id   varchar(6)    NOT NULL,
  name               varchar(255)  NOT NULL,
  deleted            boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__material_type_id UNIQUE INDEX( material_type_id )
)
ENGINE=InnoDB;

/** BUILDING TABLES */

CREATE TABLE addresses(
  id        char(36)      NOT NULL,
  address_1 varchar(255)  NOT NULL,
  address_2 varchar(255)  NULL,
  city      varchar(255)  NOT NULL,
  state     char(2)       NOT NULL,
  zip_code  varchar(255)  NOT NULL,
  PRIMARY KEY( id )
)
ENGINE=InnoDB;

CREATE TABLE buildings(
  id                    char(36)  NOT NULL,
  building_type_id      char(36)  NULL,
  address_id            char(36)  NOT NULL,
  year_built            int       NULL,
  total_sf              int       NULL,
  finished_sf           int       NULL,
  stories_above_ground  int       NULL,
  basement_type_id      char(36)  NULL,
  window_wall_ratio_id  int       NULL,
  skylight_count        int       NULL,
  window_wall           boolean   NOT NULL DEFAULT 0,
  window_wall_sf        int       NULL,
  window_wall_side      char(1)   NULL,
  shading_type_id       char(36)  NULL,
  infiltration_type_id  char(36)  NULL,
  exposure_type_id      char(36)  NULL,
  notes                 text      NULL,
  deleted               boolean   NOT NULL DEFAULT 0,
  created               datetime  NOT NULL,
  modified              datetime  NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings__addresses FOREIGN KEY( address_id )
    REFERENCES addresses( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings__building_types FOREIGN KEY( building_type_id )
    REFERENCES building_types( id )
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
  CONSTRAINT fk__buildings__infiltration_types FOREIGN KEY( infiltration_type_id )
    REFERENCES infiltration_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__buildings__exposure_types FOREIGN KEY( exposure_type_id )
    REFERENCES exposure_types( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
)
ENGINE=InnoDB;

CREATE TABLE occupants(
  id          char(36)  NOT NULL,
  building_id char(36)  NOT NULL,
  age_0_5     int       NULL,
  age_6_13    int       NULL,
  age_14_64   int       NULL,
  age_65      int       NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__occupants__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
ENGINE=InnoDB;

/** PRODUCTS AND PRODUCT JOINS */

CREATE TABLE appliances(
  id                char(36)      NOT NULL,
  appliance_type_id varchar(6)    NOT NULL,
  energy_source_id  char(36)      NOT NULL,
  name              varchar(255)  NOT NULL,
  make              varchar(255)  NOT NULL,
  model             varchar(255)  NOT NULL,
  serial_number     varchar(255)  NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__appliances__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT uix__appliance_type_id UNIQUE INDEX( appliance_type_id )
) ENGINE=InnoDB;

CREATE TABLE hot_water_systems(
  id                        char(36)      NOT NULL,
  hot_water_system_type_id  varchar(6)    NOT NULL,
  energy_source_id          char(36)      NOT NULL,
  name                      varchar(255)  NOT NULL,
  make                      varchar(255)  NOT NULL,
  model                     varchar(255)  NOT NULL,
  serial_number             varchar(255)  NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__hot_water_systems__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT uix__hot_water_system_type_id UNIQUE INDEX( hot_water_system_type_id )
) ENGINE=InnoDB;

CREATE TABLE hvac_systems(
  id                    char(36)      NOT NULL,
  hvac_system_type_id   varchar(6)    NOT NULL,
  energy_source_id      char(36)      NOT NULL,
  name                  varchar(255)  NOT NULL,
  make                  varchar(255)  NOT NULL,
  model                 varchar(255)  NOT NULL,
  serial_number         varchar(255)  NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__hvac_systems__energy_sources FOREIGN KEY( energy_source_id )
    REFERENCES energy_sources( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT uix__hvac_system_type_id UNIQUE INDEX( hvac_system_type_id )
) ENGINE=InnoDB;

CREATE TABLE roof_systems(
  id                    char(36)      NOT NULL,
  roof_system_type_id   varchar(6)    NOT NULL,
  name                  varchar(255)  NOT NULL,
  u_value               float         NULL,
  PRIMARY KEY( id ),
  CONSTRAINT uix__roof_system_type_id UNIQUE INDEX( roof_system_type_id )
) ENGINE=InnoDB;

CREATE TABLE wall_systems(
  id                  char(36)      NOT NULL,
  wall_system_type_id varchar(6)    NOT NULL,
  name                varchar(255)  NOT NULL,
  u_value             float         NULL,
  deleted             boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__wall_system_type_id UNIQUE INDEX( wall_system_type_id )
)
ENGINE=InnoDB;

CREATE TABLE window_systems(
  id                      char(36)      NOT NULL,
  window_system_type_id   varchar(6)    NOT NULL,
  name                    varchar(255)  NOT NULL,
  panes                   int           NOT NULL, 
  material_id             char(36)      NOT NULL,
  gas_filled              boolean       NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT uix__window_system_type_id UNIQUE INDEX( window_system_type_id ),
  CONSTRAINT fk__window_systems__materials FOREIGN KEY( material_id )
    REFERENCES materials( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE building_appliances(
  id            char(36)  NOT NULL,
  building_id   char(36)  NOT NULL,
  appliance_id  char(36)  NOT NULL,
  year_built    int       NULL,
  notes         text      NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__appliances_buildings__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__appliances_building__appliances FOREIGN KEY( appliance_id )
    REFERENCES appliances( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE building_hot_water_systems(
  id                    char(36)  NOT NULL,
  building_id           char(36)  NOT NULL,
  hot_water_system_id   char(36)  NOT NULL,
  notes                 text      NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings_hot_water_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings_hot_water_systems__appliances FOREIGN KEY( hot_water_system_id )
    REFERENCES hot_water_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE building_hvac_systems(
  id                char(36)  NOT NULL,
  building_id       char(36)  NOT NULL,
  hvac_system_id    char(36)  NOT NULL,
  year_installed    int       NOT NULL,
  setpoint_heating  int       NULL,
  setpoint_cooling  int       NULL,
  notes             text      NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__building_hvac_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__building_hvac_systems__hvac_systems FOREIGN KEY( hvac_system_id )
    REFERENCES hvac_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE building_roof_systems(
  id              char(36)    NOT NULL,
  building_id     char(36)    NOT NULL,
  roof_system_id  char(36)    NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings_roof_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings_roof_systems__roof_systems FOREIGN KEY( roof_system_id )
    REFERENCES roof_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE buildings_wall_systems(
  id              char(36)    NOT NULL,
  building_id    char(36)  NOT NULL,
  wall_system_id char(36)  NOT NULL,
  PRIMARY KEY( building_id, wall_system_id ),
  CONSTRAINT fk__buildings_wall_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings_wall_systems__wall_systems FOREIGN KEY( wall_system_id )
    REFERENCES wall_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE building_window_systems(
  id                char(36)  NOT NULL,
  building_id       char(36)  NOT NULL,
  window_system_id  char(36)  NOT NULL,
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings_window_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings_window_systems__roof_systems FOREIGN KEY( window_system_id )
    REFERENCES window_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

/** APPLICATION USERS & PARTNERS */

CREATE TABLE users(
  id        char(36)      NOT NULL,
  email     varchar(255)  NOT NULL,
  password  varchar(255)  NOT NULL,
  deleted   boolean       NOT NULL DEFAULT 1,
  created   datetime      NOT NULL,
  modified  datetime      NOT NULL,
  PRIMARY KEY( id )
)
ENGINE=InnoDB;

CREATE TABLE contractors(
  id      char(36)  NOT NULL,
  user_id char(36)  NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__contractors__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE homeowners(
  id      char(36)  NOT NULL,
  user_id char(36)  NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__homeowners__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE partners(
  id        char(36)      NOT NULL,
  name      varchar(255)  NOT NULL,
  created   datetime      NOT NULL,
  modified  datetime      NOT NULL,

  PRIMARY KEY( id )
) ENGINE=InnoDB;

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

/** SURVEYS */

CREATE TABLE surveys(
  id            char(36)    NOT NULL,
  contractor_id char(36)    NULL,
  homeowner_id  char(36)    NULL,
  building_id   char(36)    NULL,
  created       datetime    NOT NULL,
  modified      datetime    NOT NULL,
  deleted       boolean     NOT NULL DEFAULT 0,
  PRIMARY KEY( id ),
  CONSTRAINT fk__surveys__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__surveys__homeowners FOREIGN KEY( homeowner_id )
    REFERENCES homeowners( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL,
  CONSTRAINT fk__surveys__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;
