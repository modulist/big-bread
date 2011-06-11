USE @DB_NAME@;

SET foreign_key_checks = 0;

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
) ENGINE=InnoDB;

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
) ENGINE=InnoDB;

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
) ENGINE=InnoDB;

-- Defines the manufacturers whose equipment a contractor services
-- and whether the contractor is certified for the manufacture's
-- incentive programs.
DROP TABLE IF EXISTS manufacturer_incentive_certifications;
CREATE TABLE manufacturer_incentive_certifications(
  id                        char(36)  NOT NULL,
  contractor_id             char(36)  NOT NULL,
  equipment_manufacturer_id char(36)  NOT NULL,
  -- certification_number?
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__contractor_id__equipment_manufacturer_id
    UNIQUE INDEX( contractor_id, equipment_manufacturer_id ),
  CONSTRAINT fk__manufacturer_incentive_certifications__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__manufacturer_incentive_certifications__equip_manuf FOREIGN KEY( equipment_manufacturer_id )
    REFERENCES equipment_manufacturers( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Defines the relationship between a contractor and utilities in the
-- areas s/he services. If a relationship exists, it's because the
-- contractor is incentive certified by that utility.
DROP TABLE IF EXISTS utility_incentive_certifications;
CREATE TABLE utility_incentive_certifications(
  id                  char(36)  NOT NULL,
  contractor_id       char(36)  NOT NULL,
  utility_id          char(36)  NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT uix__contractor_id__utility_id
    UNIQUE INDEX( contractor_id, utility_id ),
  CONSTRAINT fk__utility_incentive_certifications__contractors FOREIGN KEY( contractor_id )
    REFERENCES contractors( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__utility_incentive_certifications__utility FOREIGN KEY( utility_id )
    REFERENCES utility( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

SET foreign_key_checks = 1;
