USE @DB_NAME@;

SET foreign_key_checks = 0;

-- Changes to support API usage
INSERT INTO user_types( id, code, name, deleted )
VALUES( UUID(), 'API', 'API Consumer', 0 );

-- Create codes for other user types
UPDATE user_types
   SET code = 'OWNER'
 WHERE name = 'Homeowner';

UPDATE user_types
   SET code = 'BUYER'
 WHERE name = 'Buyer';

UPDATE user_types
   SET code = 'REALTR'
 WHERE name = 'Realtor';

UPDATE user_types
   SET code = 'INSPCT'
 WHERE name = 'Inspector';
 
-- Manage API users separately, but link to users via POC
DROP TABLE IF EXISTS api_users;
CREATE TABLE api_users(
  id            char(36)      NOT NULL,
  user_id       char(36)      NOT NULL, -- point of contact (poc)
  name          varchar(255)  NOT NULL, -- a pretty, non-personal display name
  description   text          NULL,     -- free form field for additional info (probably admin)
  api_key       char(32)      NOT NULL,
  created       datetime      NOT NULL,
  modified      datetime      NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__api_users__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;
  
-- Original tables no longer necessary
DROP TABLE partner_domains;
DROP TABLE partners;

SET foreign_key_checks = 1;
