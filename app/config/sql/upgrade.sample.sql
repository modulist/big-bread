USE @DB_NAME@;

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

CREATE TABLE contacts(
  id          char(36)        NOT NULL,
  first_name  varchar(255)    NULL,
  last_name   varchar(255)    NULL,
  email       varchar(255)    NULL,
  deleted     boolean         NOT NULL DEFAULT 0,
  PRIMARY KEY( id )
)
ENGINE=InnoDB;

CREATE TABLE realtors(
  contact_id    char(36)    NOT NULL,
  building_id   char(36)    NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT fk__buildings_realtors__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk__buildings_realtors__contacts FOREIGN KEY( contact_id )
    REFERENCES window_systems( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
  
) ENGINE=InnoDB;

ALTER TABLE users
  ADD COLUMN last_login datetime NULL;

ALTER TABLE buildings
  ADD COLUMN efficiency_rating  int   NULL
    BEFORE notes,
  ADD COLUMN warranty_info      text  NULL,
    BEFORE notes,
  ADD COLUMN recall_info        text  NULL
    BEFORE notes;
  
