USE @DB_NAME@;

SET foreign_key_checks = 0;

-- Store equipment manufacturers with technology links.
DROP TABLE IF EXISTS equipment_manufacturers;
CREATE TABLE equipment_manufacturers(
  id            char(36)      NOT NULL,
  name          varchar(255)  NOT NULL, -- a pretty, non-personal display name
  description   text          NULL,     -- free form field for additional info (probably admin)
  created       datetime      NOT NULL,
  modified      datetime      NOT NULL,
  
  PRIMARY KEY( id )
) ENGINE=InnoDB;

DROP TABLE IF EXISTS equipment_manufacturers_technologies;
CREATE TABLE equipment_manufacturers(
  equipment_manufacturer_id   char(36)  NOT NULL,
  technology_id               char(36)  NOT NULL,
  created                     datetime      NOT NULL,
  modified                    datetime      NOT NULL,
  
  CONSTRAINT uix__equipment_manufacturer_id__technology_id
    UNIQUE INDEX( equipment_manufacturer_id, technology_id ),
  CONSTRAINT fk__equipment_manufacturers_technologies__equipment_manufacturers FOREIGN KEY( equipment_manufacturer_id )
    REFERENCES equipment_manufacturers( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,  
  CONSTRAINT fk__equipment_manufacturers_technologies__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
) ENGINE=InnoDB;

SET @ac = 'c48c6d7a-6f7f-11e0-be41-80593d270cc9';
SET @hp = 'c48c7874-6f7f-11e0-be41-80593d270cc9';
SET @wh = 'c48c9944-6f7f-11e0-be41-80593d270cc9';

SET @uuid = UUID();
INSERT INTO equipment_manufacturers( id, name, created, modified )
VALUES ( @uuid, 'AAON, INC.', NOW(), NOW() );

INSERT INTO equipment_manufacturers_technologies
VALUES
  ( @uuid, @ac, NOW(), NOW() )
  ( @uuid, @hp, NOW(), NOW() );
--
SET @uuid = UUID();
INSERT INTO equipment_manufacturers( id, name, created, modified )
VALUES ( @uuid, 'AEROSYS, INC.', NOW(), NOW() );

INSERT INTO equipment_manufacturers_technologies
VALUES
  ( @uuid, @ac, NOW(), NOW() );
-- 
SET @uuid = UUID();
INSERT INTO equipment_manufacturers( id, name, created, modified )
VALUES ( @uuid, 'AIR-CON INTERNATIONAL, INC.', NOW(), NOW() );

INSERT INTO equipment_manufacturers_technologies
VALUES
  ( @uuid, @ac, NOW(), NOW() )
  ( @uuid, @hp, NOW(), NOW() );
-- 
SET @uuid = UUID();
INSERT INTO equipment_manufacturers( id, name, created, modified )
VALUES ( @uuid, 'AIRE-FLO', NOW(), NOW() );

INSERT INTO equipment_manufacturers_technologies
VALUES
  ( @uuid, @ac, NOW(), NOW() )
  ( @uuid, @hp, NOW(), NOW() );
-- 
SET @uuid = UUID();
INSERT INTO equipment_manufacturers( id, name, created, modified )
VALUES ( @uuid, 'AIREASE', NOW(), NOW() );

INSERT INTO equipment_manufacturers_technologies
VALUES
  ( @uuid, @ac, NOW(), NOW() )
  ( @uuid, @hp, NOW(), NOW() );


-- New equipment data
ALTER TABLE building_products
  ADD purchase_price float(10,2) NULL AFTER serial_number,
  ADD created datetime NULL,
  ADD modified datetime NULL;

SET foreign_key_checks = 1;
