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
