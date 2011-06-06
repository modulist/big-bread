USE @DB_NAME@;

SET foreign_key_checks = 0;

-- New equipment data
ALTER TABLE building_products
  ADD purchase_price float(10,2) NULL AFTER serial_number,
  ADD created datetime NULL,
  ADD modified datetime NULL;

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
CREATE TABLE equipment_manufacturers_technologies(
  equipment_manufacturer_id   char(36)  NOT NULL,
  technology_id               char(36)  NOT NULL,
  created                     datetime      NOT NULL,
  modified                    datetime      NOT NULL,
  
  CONSTRAINT uix__equipment_manufacturer_id__technology_id
    UNIQUE INDEX( equipment_manufacturer_id, technology_id ),
  CONSTRAINT fk__equip_manuf_tech__equipment_manufacturers FOREIGN KEY( equipment_manufacturer_id )
    REFERENCES equipment_manufacturers( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE,  
  CONSTRAINT fk__equip_manuf_tech__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert manufacturer data and technology links
-- Air Conditioner Manufacturers
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a185014b-9d01-40ba-9e9d-129afc4e226d','AAON, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a185014b-9d01-40ba-9e9d-129afc4e226d', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8540d253-1f4f-4373-b18d-3f42ef610f04','AEROSYS, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8540d253-1f4f-4373-b18d-3f42ef610f04', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bafb9393-a751-4e08-b23c-7fec23768efd','AIR-CON INTERNATIONAL, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bafb9393-a751-4e08-b23c-7fec23768efd', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '1540bf4d-65fb-4ffd-942f-07ceef7b7d25','AIRE-FLO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '1540bf4d-65fb-4ffd-942f-07ceef7b7d25', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd8e98370-41f4-4707-a308-e60c14db9442','AIREASE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd8e98370-41f4-4707-a308-e60c14db9442', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e750d2d5-7e0e-4940-91a3-f839d0eafacd','AIRQUEST',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e750d2d5-7e0e-4940-91a3-f839d0eafacd', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '5870a1fe-178b-4180-9320-2b1a5483c5b9','AMANA HEATING AND AIR CONDITIONING',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '5870a1fe-178b-4180-9320-2b1a5483c5b9', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4ba78d33-8d06-4637-997f-13b95cdce5b5','AMERICAN STANDARD, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4ba78d33-8d06-4637-997f-13b95cdce5b5', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f1f631bd-a3e6-42f8-9fa1-a6b0e45d8290','ARCOAIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f1f631bd-a3e6-42f8-9fa1-a6b0e45d8290', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '3f96e542-a64c-4477-86fe-5165cd62b139','ARMSTRONG AIR CONDITIONING, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3f96e542-a64c-4477-86fe-5165cd62b139', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b5f5fdd2-c4de-45e4-a669-b0d686973733','BARD MANUFACTURING COMPANY',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b5f5fdd2-c4de-45e4-a669-b0d686973733', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4f3d7782-3885-46b2-be67-20a07f7b6dbe','BEUTLER CORPORATION',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4f3d7782-3885-46b2-be67-20a07f7b6dbe', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ff02c2be-0675-406b-b0f9-1001f8aba391','BROAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ff02c2be-0675-406b-b0f9-1001f8aba391', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '7e9cc4bf-524b-40ff-85a1-2ca991040d2a','BRYANT HEATING AND COOLING SYSTEMS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7e9cc4bf-524b-40ff-85a1-2ca991040d2a', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'effd3777-bd76-479a-8ff6-9ec1138e6703','CARRIER AIR CONDITIONING',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'effd3777-bd76-479a-8ff6-9ec1138e6703', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd56a6ab2-77be-41ef-b7d7-f3a9b541888c','COAIRE CORPORATION',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd56a6ab2-77be-41ef-b7d7-f3a9b541888c', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9bd04bb3-acac-49eb-bf58-f91151b58beb','COLD POINT CORP.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9bd04bb3-acac-49eb-bf58-f91151b58beb', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '10ab31d9-6b70-4b27-93ab-38bd05517a46','COLEMAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '10ab31d9-6b70-4b27-93ab-38bd05517a46', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '3d7ac7ff-6d42-48cc-b7f1-29d0f2679fe7','COMFORTMAKER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3d7ac7ff-6d42-48cc-b7f1-29d0f2679fe7', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a5864f6b-3df9-4652-8b61-30c03d67930e','CONCORD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a5864f6b-3df9-4652-8b61-30c03d67930e', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '05ec6529-d405-4e41-9984-b8b90c99fc6a','DAY & NIGHT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '05ec6529-d405-4e41-9984-b8b90c99fc6a', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0128ee54-34d0-4c0c-9b54-1b0d07f6e32a','DAYTON ELECTRIC MANUFACTURING COMPANY',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0128ee54-34d0-4c0c-9b54-1b0d07f6e32a', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '07c710be-84da-4fb7-aeeb-f3ea67bed74b','DIAMONDAIR, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '07c710be-84da-4fb7-aeeb-f3ea67bed74b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '457d0116-d28d-42bb-9dbd-4f597ae979e3','DUCANE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '457d0116-d28d-42bb-9dbd-4f597ae979e3', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c5582a32-bc0d-49b6-8f54-762f4e86f539','EAIR LLC',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c5582a32-bc0d-49b6-8f54-762f4e86f539', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bb4fde65-43ae-4037-a16f-9444f01354e1','ECOTEMP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bb4fde65-43ae-4037-a16f-9444f01354e1', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b08a524a-120c-4d91-85eb-2e163e255b70','ELECT-AIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b08a524a-120c-4d91-85eb-2e163e255b70', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4308f2b5-0463-4360-8193-709bd4a5d42b','ENVIROMASTER INTERNATIONAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4308f2b5-0463-4360-8193-709bd4a5d42b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bed0c6c8-2391-465a-89c3-9719c9879432','EVOCON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bed0c6c8-2391-465a-89c3-9719c9879432', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4b35e5d8-e67f-4df6-87ad-804d4fb6e2c7','FRASER - JOHNSTON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4b35e5d8-e67f-4df6-87ad-804d4fb6e2c7', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'edc9ae54-1760-485b-9a90-642227ab50f2','FRIGIDAIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'edc9ae54-1760-485b-9a90-642227ab50f2', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '3b46af43-7464-475a-8f6f-c5090d761cea','FUJITSU',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3b46af43-7464-475a-8f6f-c5090d761cea', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '41b61c42-83e4-4a62-9fe0-13740e056919','GARRISON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '41b61c42-83e4-4a62-9fe0-13740e056919', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bf68ab3a-94d1-4109-b63a-5e0bfcedf3e4','GD MIDEA',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bf68ab3a-94d1-4109-b63a-5e0bfcedf3e4', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b681f13b-37c8-4566-b5a7-a58072f9e376','GIBSON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b681f13b-37c8-4566-b5a7-a58072f9e376', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b477c86b-7041-4388-8c9c-ed0a751eec2b','GOODMAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b477c86b-7041-4388-8c9c-ed0a751eec2b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '91a24468-8e8a-47d8-b946-2ff66a0c82b8','GRANDAIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '91a24468-8e8a-47d8-b946-2ff66a0c82b8', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '02464bf1-7dd9-4ed3-860a-4077c0e89c97','GREE ELECTRIC',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '02464bf1-7dd9-4ed3-860a-4077c0e89c97', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '96f66271-4e17-4fb6-b43e-813d40e28526','GUARDIAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '96f66271-4e17-4fb6-b43e-813d40e28526', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bd6bc6ab-c26e-4873-9735-5b10a86bc035','HAIER AMERICA',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bd6bc6ab-c26e-4873-9735-5b10a86bc035', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8d5ed146-8295-45dd-ac89-edd1df29edc1','HEAT CONTROLLER, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8d5ed146-8295-45dd-ac89-edd1df29edc1', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ba496092-54b6-4e71-b6af-6c2227d592e7','HEIL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ba496092-54b6-4e71-b6af-6c2227d592e7', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c64ce9b6-43a0-4052-a58b-6154edae0c51','ICP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c64ce9b6-43a0-4052-a58b-6154edae0c51', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c7c280d5-9d5d-4761-be7a-e40bf7f4cc07','INNOVAIR CORPORATION',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c7c280d5-9d5d-4761-be7a-e40bf7f4cc07', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4f8a6ded-331a-4210-b107-668e64f5fe41','INTERTHERM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4f8a6ded-331a-4210-b107-668e64f5fe41', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b4fa5b33-8700-45c2-8632-6b793f5ac097','JOHNSON CONTROLS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b4fa5b33-8700-45c2-8632-6b793f5ac097', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0eff784e-d67c-4264-90ea-6f4d1be5b2a3','KEEPRITE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0eff784e-d67c-4264-90ea-6f4d1be5b2a3', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c4bb56f4-29f2-4c01-a8dc-eefc9f5d5856','KELVINATOR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c4bb56f4-29f2-4c01-a8dc-eefc9f5d5856', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '407ec36f-3ff3-4100-a717-c145a1d0d76b','KENMORE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '407ec36f-3ff3-4100-a717-c145a1d0d76b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f5cc87ec-c2ca-48d3-8d7d-547b14eae7fc','KLIMAIRE PRODUCTS INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f5cc87ec-c2ca-48d3-8d7d-547b14eae7fc', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '669e5840-4e7b-494e-8299-64e557f0269d','LENNOX INDUSTRIES, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '669e5840-4e7b-494e-8299-64e557f0269d', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '2bd81844-c66d-4540-8fbf-6ec83f8bb40b','LG ELECTRONICS, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bd81844-c66d-4540-8fbf-6ec83f8bb40b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a035f4f8-3314-4b87-9ae8-4abeb6856594','LUXAIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a035f4f8-3314-4b87-9ae8-4abeb6856594', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '2bff7623-5bb3-401e-a213-d58a2f7ba71a','MARATHERM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bff7623-5bb3-401e-a213-d58a2f7ba71a', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6632a4ca-1149-42e8-b1de-6e49468ca3a2','MAYTAG',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6632a4ca-1149-42e8-b1de-6e49468ca3a2', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b95eeb6c-6f0f-4f8f-a402-4853143dc4cc','MCQUAY INTERNATIONAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b95eeb6c-6f0f-4f8f-a402-4853143dc4cc', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '89b2d691-1bd7-4a54-849b-6eb781840fa1','MEDALLION',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '89b2d691-1bd7-4a54-849b-6eb781840fa1', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '92e99f08-5a41-4035-adc3-4f4097eee4af','MILLER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '92e99f08-5a41-4035-adc3-4f4097eee4af', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '413da143-a893-4097-96e5-0c8ef80d25f1','MITSUBISHI',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '413da143-a893-4097-96e5-0c8ef80d25f1', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '28690ad2-5d8d-4258-ace4-dac570d51f97','NATIONAL COMFORT PRODUCTS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '28690ad2-5d8d-4258-ace4-dac570d51f97', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'fc801f45-dc31-4362-a8aa-d21e8901f0d9','NORDYNE, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'fc801f45-dc31-4362-a8aa-d21e8901f0d9', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'aa600925-3d75-4ca8-9417-1b4cc8246d78','NUTONE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'aa600925-3d75-4ca8-9417-1b4cc8246d78', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '71237b31-c1eb-4740-bd07-7d3bf2bcb1b7','PAYNE HEATING AND COOLING',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '71237b31-c1eb-4740-bd07-7d3bf2bcb1b7', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4715e7fd-35a5-427c-aa47-a76879776c01','PHILCO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4715e7fd-35a5-427c-aa47-a76879776c01', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b2092f5f-d3c5-4f33-b5e5-df3a9836a4d3','QUIETSIDE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b2092f5f-d3c5-4f33-b5e5-df3a9836a4d3', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f37b3b17-3a58-4d60-afe5-0b1c78769919','RHEEM MANUFACTURING',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f37b3b17-3a58-4d60-afe5-0b1c78769919', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6cdc2574-9529-4644-bdec-a9af938846f2','RICHMOND',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6cdc2574-9529-4644-bdec-a9af938846f2', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '014c6833-0ed2-4f33-93b5-28ad8b5d87c5','RUUD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '014c6833-0ed2-4f33-93b5-28ad8b5d87c5', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b8cb6365-3f5c-427c-81be-549488265f3b','TAPPAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b8cb6365-3f5c-427c-81be-549488265f3b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e8f43ad3-5df6-4cb9-88b4-811c7f3b113b','TEMPSTAR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e8f43ad3-5df6-4cb9-88b4-811c7f3b113b', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ec93246e-e575-4d11-acf4-ecadfc9fae0e','TEXAS FURNACE, LLC',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ec93246e-e575-4d11-acf4-ecadfc9fae0e', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b501122a-8062-4c6f-a72d-b8c410d9cb23','THERMO PRODUCTS, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b501122a-8062-4c6f-a72d-b8c410d9cb23', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bfa0bc18-1202-45ce-9cbc-f129a0c4e949','TRANE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bfa0bc18-1202-45ce-9cbc-f129a0c4e949', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '32996e0a-63af-4b9c-aa9c-fcd8bd853950','UNITED REFRIGERATION DISTRIBUTORS, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '32996e0a-63af-4b9c-aa9c-fcd8bd853950', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '502b07ae-c124-47a4-bc7f-1d392ce8443d','V-AIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '502b07ae-c124-47a4-bc7f-1d392ce8443d', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'aaa43115-a855-466e-86c0-9532a74be465','WEATHERKING',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'aaa43115-a855-466e-86c0-9532a74be465', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '41313f47-ea35-4f4f-bb19-ad9e43e7a90d','WESTINGHOUSE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '41313f47-ea35-4f4f-bb19-ad9e43e7a90d', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '16d1ba58-50f0-4dd2-be92-8dd3971b3696','WHIRLPOOL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '16d1ba58-50f0-4dd2-be92-8dd3971b3696', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'debf69c2-8bd6-4e8a-89c6-832ae2db0921','XENON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'debf69c2-8bd6-4e8a-89c6-832ae2db0921', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '39ce551a-3039-499e-8b0d-aa7098a5bae7','YORK',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '39ce551a-3039-499e-8b0d-aa7098a5bae7', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '2bdbc27f-d012-4322-8388-731886d6a86d','YOUR SOURCE PRODUCTS, INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bdbc27f-d012-4322-8388-731886d6a86d', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );

-- Heat Pump Manufacturers
-- Skipping 'AAON, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a185014b-9d01-40ba-9e9d-129afc4e226d', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AIR-CON INTERNATIONAL, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bafb9393-a751-4e08-b23c-7fec23768efd', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AIRE-FLO' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '1540bf4d-65fb-4ffd-942f-07ceef7b7d25', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AIREASE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd8e98370-41f4-4707-a308-e60c14db9442', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AIRQUEST' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e750d2d5-7e0e-4940-91a3-f839d0eafacd', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AMANA HEATING AND AIR CONDITIONING' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '5870a1fe-178b-4180-9320-2b1a5483c5b9', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'AMERICAN STANDARD, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4ba78d33-8d06-4637-997f-13b95cdce5b5', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ARCOAIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f1f631bd-a3e6-42f8-9fa1-a6b0e45d8290', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ARMSTRONG AIR CONDITIONING, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3f96e542-a64c-4477-86fe-5165cd62b139', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'BARD MANUFACTURING COMPANY' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b5f5fdd2-c4de-45e4-a669-b0d686973733', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'BROAN' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ff02c2be-0675-406b-b0f9-1001f8aba391', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'BRYANT HEATING AND COOLING SYSTEMS' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7e9cc4bf-524b-40ff-85a1-2ca991040d2a', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'CARRIER AIR CONDITIONING' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'effd3777-bd76-479a-8ff6-9ec1138e6703', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'COAIRE CORPORATION' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd56a6ab2-77be-41ef-b7d7-f3a9b541888c', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'COLEMAN' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '10ab31d9-6b70-4b27-93ab-38bd05517a46', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'COMFORTMAKER' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3d7ac7ff-6d42-48cc-b7f1-29d0f2679fe7', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'CONCORD' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a5864f6b-3df9-4652-8b61-30c03d67930e', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'DAY & NIGHT' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '05ec6529-d405-4e41-9984-b8b90c99fc6a', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'DAYTON ELECTRIC MANUFACTURING COMPANY' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0128ee54-34d0-4c0c-9b54-1b0d07f6e32a', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'DIAMONDAIR, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '07c710be-84da-4fb7-aeeb-f3ea67bed74b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'DUCANE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '457d0116-d28d-42bb-9dbd-4f597ae979e3', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'EAIR LLC' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c5582a32-bc0d-49b6-8f54-762f4e86f539', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ECOTEMP' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bb4fde65-43ae-4037-a16f-9444f01354e1', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ELECT-AIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b08a524a-120c-4d91-85eb-2e163e255b70', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ENVIROMASTER INTERNATIONAL' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4308f2b5-0463-4360-8193-709bd4a5d42b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'EVOCON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bed0c6c8-2391-465a-89c3-9719c9879432', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'FRASER - JOHNSTON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4b35e5d8-e67f-4df6-87ad-804d4fb6e2c7', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'FRIGIDAIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'edc9ae54-1760-485b-9a90-642227ab50f2', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'FUJITSU' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3b46af43-7464-475a-8f6f-c5090d761cea', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GARRISON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '41b61c42-83e4-4a62-9fe0-13740e056919', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GD MIDEA' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bf68ab3a-94d1-4109-b63a-5e0bfcedf3e4', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GIBSON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b681f13b-37c8-4566-b5a7-a58072f9e376', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GOODMAN' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b477c86b-7041-4388-8c9c-ed0a751eec2b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GRANDAIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '91a24468-8e8a-47d8-b946-2ff66a0c82b8', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GREE ELECTRIC' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '02464bf1-7dd9-4ed3-860a-4077c0e89c97', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '3c36cb4e-5188-435d-8f7b-6570e067ed39','GUANGDONG CHIGO AIR-CONDITIONING CO., LTD.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '3c36cb4e-5188-435d-8f7b-6570e067ed39', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GUARDIAN' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '96f66271-4e17-4fb6-b43e-813d40e28526', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'HAIER AMERICA' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bd6bc6ab-c26e-4873-9735-5b10a86bc035', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'HEAT CONTROLLER, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8d5ed146-8295-45dd-ac89-edd1df29edc1', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'HEIL' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ba496092-54b6-4e71-b6af-6c2227d592e7', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '141707d9-59b6-4c7e-9e6f-18eb3cf0778c','ICECO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '141707d9-59b6-4c7e-9e6f-18eb3cf0778c', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'ICP' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c64ce9b6-43a0-4052-a58b-6154edae0c51', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'INTERTHERM' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4f8a6ded-331a-4210-b107-668e64f5fe41', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'JOHNSON CONTROLS' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b4fa5b33-8700-45c2-8632-6b793f5ac097', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'KEEPRITE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0eff784e-d67c-4264-90ea-6f4d1be5b2a3', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'KELVINATOR' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c4bb56f4-29f2-4c01-a8dc-eefc9f5d5856', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'KENMORE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '407ec36f-3ff3-4100-a717-c145a1d0d76b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'KLIMAIRE PRODUCTS INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f5cc87ec-c2ca-48d3-8d7d-547b14eae7fc', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '05128ac1-480b-407e-b2ae-7757c1c2cf8e','LE PROHON INC.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '05128ac1-480b-407e-b2ae-7757c1c2cf8e', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'LENNOX INDUSTRIES, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '669e5840-4e7b-494e-8299-64e557f0269d', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'LG ELECTRONICS, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bd81844-c66d-4540-8fbf-6ec83f8bb40b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'LUXAIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a035f4f8-3314-4b87-9ae8-4abeb6856594', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'MARATHERM' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bff7623-5bb3-401e-a213-d58a2f7ba71a', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'MAYTAG' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6632a4ca-1149-42e8-b1de-6e49468ca3a2', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e40ee1fb-c891-41e4-a221-2261605b1cb0','MEQUAY INTERNATIONAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e40ee1fb-c891-41e4-a221-2261605b1cb0', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'MEDALLION' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '89b2d691-1bd7-4a54-849b-6eb781840fa1', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'MILLER' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '92e99f08-5a41-4035-adc3-4f4097eee4af', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'NATIONAL COMFORT PRODUCTS' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '28690ad2-5d8d-4258-ace4-dac570d51f97', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'NORDYNE, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'fc801f45-dc31-4362-a8aa-d21e8901f0d9', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'NUTONE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'aa600925-3d75-4ca8-9417-1b4cc8246d78', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'PAYNE HEATING AND COOLING' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '71237b31-c1eb-4740-bd07-7d3bf2bcb1b7', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'PHILCO' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4715e7fd-35a5-427c-aa47-a76879776c01', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e73da093-78bd-4588-a78e-ad220f83d3f5','PRIDIOM GROUP LLC',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e73da093-78bd-4588-a78e-ad220f83d3f5', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'QUIETSIDE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b2092f5f-d3c5-4f33-b5e5-df3a9836a4d3', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'RHEEM MANUFACTURING' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f37b3b17-3a58-4d60-afe5-0b1c78769919', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'RICHMOND' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6cdc2574-9529-4644-bdec-a9af938846f2', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'RUUD' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '014c6833-0ed2-4f33-93b5-28ad8b5d87c5', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bdd35372-2d8e-42e1-b16f-d9cea1ce8739','SAMSUNG ELECTRONICS CO. LTD.',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bdd35372-2d8e-42e1-b16f-d9cea1ce8739', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'TAPPAN' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b8cb6365-3f5c-427c-81be-549488265f3b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'TEMPSTAR' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e8f43ad3-5df6-4cb9-88b4-811c7f3b113b', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'TEXAS FURNACE, LLC' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ec93246e-e575-4d11-acf4-ecadfc9fae0e', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'TRANE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bfa0bc18-1202-45ce-9cbc-f129a0c4e949', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'UNITED REFRIGERATION DISTRIBUTORS, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '32996e0a-63af-4b9c-aa9c-fcd8bd853950', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'V-AIRE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '502b07ae-c124-47a4-bc7f-1d392ce8443d', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'WEATHERKING' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'aaa43115-a855-466e-86c0-9532a74be465', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'WESTINGHOUSE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '41313f47-ea35-4f4f-bb19-ad9e43e7a90d', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'WHIRLPOOL' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '16d1ba58-50f0-4dd2-be92-8dd3971b3696', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'XENON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'debf69c2-8bd6-4e8a-89c6-832ae2db0921', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'YORK' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '39ce551a-3039-499e-8b0d-aa7098a5bae7', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'YOUR SOURCE PRODUCTS, INC.' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2bdbc27f-d012-4322-8388-731886d6a86d', 'c48c7874-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );

-- Water Heater Manufacturers
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0277c2e7-11b3-43b2-9646-d698cf45e1bf','A.O. SMITH',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0277c2e7-11b3-43b2-9646-d698cf45e1bf', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0b8ca46e-171f-4b35-ab46-42194f7d76f3','ACE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0b8ca46e-171f-4b35-ab46-42194f7d76f3', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd46f802e-204e-4efa-949d-b2efb4ca548a','AIRTAP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd46f802e-204e-4efa-949d-b2efb4ca548a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '07fb36dd-1735-43dc-a7bb-fb4332b610f2','AMERICAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '07fb36dd-1735-43dc-a7bb-fb4332b610f2', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6e3302c8-7ec6-4e59-84d2-b62db8922d79','AMERICAN HARDWARE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6e3302c8-7ec6-4e59-84d2-b62db8922d79', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '29dda847-cf56-45de-990c-cc027b4a9a23','AMERICAS BEST',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '29dda847-cf56-45de-990c-cc027b4a9a23', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd021ba23-26b3-4435-adde-a217480acfaa','APEX',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd021ba23-26b3-4435-adde-a217480acfaa', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f92c2c5a-a506-49ac-b1d4-a89d6da7735a','APPOLLO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f92c2c5a-a506-49ac-b1d4-a89d6da7735a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '76ca4f2e-a839-46e0-a3da-6fec2b33ea5e','AQUA TEMP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '76ca4f2e-a839-46e0-a3da-6fec2b33ea5e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '95f87c5d-d19e-4259-b4de-a61b5760d3ca','AQUA THERM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '95f87c5d-d19e-4259-b4de-a61b5760d3ca', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '5d7fc73b-e8df-4b09-8501-0fae6b39de22','AQUAMATIC',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '5d7fc73b-e8df-4b09-8501-0fae6b39de22', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '244454ff-88b6-492e-b976-fca39e9543a1','AQUASTAR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '244454ff-88b6-492e-b976-fca39e9543a1', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd613364c-4296-41a5-9706-4a0c00e50595','BEST',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd613364c-4296-41a5-9706-4a0c00e50595', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '738126a2-ffda-4d32-923a-2fe0b922ab82','BEST DELUXE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '738126a2-ffda-4d32-923a-2fe0b922ab82', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f78aa787-b028-41f3-81ec-aaf90494f409','BOCK',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f78aa787-b028-41f3-81ec-aaf90494f409', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b1878bdc-fd46-4ac4-ab8b-eae23f21cdec','BOSCH',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b1878bdc-fd46-4ac4-ab8b-eae23f21cdec', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c8e032e5-a295-4fc6-8ba0-657f7ae2c63b','BRADFORD WHITE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c8e032e5-a295-4fc6-8ba0-657f7ae2c63b', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '1647ef85-5078-488f-b10e-a5ce07fa1c6d','CHAMPION',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '1647ef85-5078-488f-b10e-a5ce07fa1c6d', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8bd2a053-9e34-4bb4-8ff5-ef77d3981ea0','CRAFTMASTER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8bd2a053-9e34-4bb4-8ff5-ef77d3981ea0', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bb151775-535f-4a45-8c1c-cd8488aa1882','D.W. WHITEHEAD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bb151775-535f-4a45-8c1c-cd8488aa1882', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '679780ee-0d0a-4a88-bf89-4dea05da735a','DE-LIMER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '679780ee-0d0a-4a88-bf89-4dea05da735a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c45ebee2-6c08-4df2-9489-7e848ab582a9','DELUXE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c45ebee2-6c08-4df2-9489-7e848ab582a9', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b1ac97dd-6316-45f8-b1c5-e9584f9bc972','EAGLE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b1ac97dd-6316-45f8-b1c5-e9584f9bc972', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0bb2fe95-129d-4f93-a912-77e94076168a','ECONOMIZER 6',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0bb2fe95-129d-4f93-a912-77e94076168a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '496ad7aa-2538-47d9-b53c-f47c99134384','ECOSENSE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '496ad7aa-2538-47d9-b53c-f47c99134384', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b3d5e404-917e-4ed3-a057-5ee41ec8156b','EEMAX',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b3d5e404-917e-4ed3-a057-5ee41ec8156b', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f4d519e2-8b2f-44bb-9368-efba155727fc','ENERGY SAVER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f4d519e2-8b2f-44bb-9368-efba155727fc', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '10c83b2a-d41c-4eae-beb9-fc7b07ca27bc','ENERGY SERVER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '10c83b2a-d41c-4eae-beb9-fc7b07ca27bc', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '423563b7-59cb-4d58-8b62-2083dd32cfda','ENVIROTEMP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '423563b7-59cb-4d58-8b62-2083dd32cfda', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'cbb9b4de-e0c6-4dcf-9e17-44109bef603c','FOUR MOST',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'cbb9b4de-e0c6-4dcf-9e17-44109bef603c', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bd52a232-2657-43a9-839f-f673caff3cef','FREEDOM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bd52a232-2657-43a9-839f-f673caff3cef', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'GARRISON' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '41b61c42-83e4-4a62-9fe0-13740e056919', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e1f171e2-85e3-4b3e-9ff2-3adb9b891bd5','GE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e1f171e2-85e3-4b3e-9ff2-3adb9b891bd5', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd97ad931-b994-4a16-8022-b8fbb2ecc3db','GIANT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd97ad931-b994-4a16-8022-b8fbb2ecc3db', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c59b649f-d0c6-43e8-a070-7bf729f9a21e','GLASCOTE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c59b649f-d0c6-43e8-a070-7bf729f9a21e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '7fd81abe-4da1-4e0e-bf02-afa726db6c13','GSW',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7fd81abe-4da1-4e0e-bf02-afa726db6c13', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9ffffcd1-20d8-4de7-986e-d363ed9e24db','HOTMASTER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9ffffcd1-20d8-4de7-986e-d363ed9e24db', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f24d3567-22f2-4662-8ec5-6820263dd23f','HOTPOINT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f24d3567-22f2-4662-8ec5-6820263dd23f', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '82243640-b20c-4d7d-a8ca-b1cb65303683','HOTSTREAM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '82243640-b20c-4d7d-a8ca-b1cb65303683', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c2dcb91d-cb3b-4678-830e-7464d3c2d129','HTP',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c2dcb91d-cb3b-4678-830e-7464d3c2d129', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e94b20d5-b616-4b1b-930c-4bc1f428fa9e','HYDROHEAT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e94b20d5-b616-4b1b-930c-4bc1f428fa9e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'aea95417-fd39-4c1b-b0bc-4a7554647fd9','HYDROHOT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'aea95417-fd39-4c1b-b0bc-4a7554647fd9', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'de58b215-f040-451e-9589-c8e475d944ec','JETGLAS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'de58b215-f040-451e-9589-c8e475d944ec', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '00f3a6d4-4981-4c9c-bee5-7a34de4fd4b7','JOHNWOOD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '00f3a6d4-4981-4c9c-bee5-7a34de4fd4b7', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'KENMORE' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '407ec36f-3ff3-4100-a717-c145a1d0d76b', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c83a73d1-f96c-4f7b-98b9-bbafca39893a','KING-KLEEN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c83a73d1-f96c-4f7b-98b9-bbafca39893a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '23648c43-3f81-4d8c-9ade-8988f0ce8c90','KING-LINE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '23648c43-3f81-4d8c-9ade-8988f0ce8c90', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9a57cc63-7fa5-48d6-8cc6-608e926a0c85','LOCHINVAR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9a57cc63-7fa5-48d6-8cc6-608e926a0c85', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '79df7180-dde6-4176-9820-25a97c272cae','MARATHON',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '79df7180-dde6-4176-9820-25a97c272cae', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '83b63fba-470a-42fe-971c-8f0617f6b3da','MASTER PLUMBER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '83b63fba-470a-42fe-971c-8f0617f6b3da', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '529ce8c1-18f7-44a3-a7d0-546bbd2afa14','MEDIAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '529ce8c1-18f7-44a3-a7d0-546bbd2afa14', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '40bda6b8-8e51-4aba-a3d8-9dc34a6edd92','MOFFAT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '40bda6b8-8e51-4aba-a3d8-9dc34a6edd92', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '5c02c849-8a0c-4915-add4-89847acd1957','MONITOR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '5c02c849-8a0c-4915-add4-89847acd1957', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd98d79d5-b9ff-41e0-bc8a-6558dd8d5ce3','NATIONAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd98d79d5-b9ff-41e0-bc8a-6558dd8d5ce3', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f16661fa-90ff-46a1-8827-a812a5880df6','NATIONALINE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f16661fa-90ff-46a1-8827-a812a5880df6', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bcd7515e-dbfe-49ab-93b1-545d9ef2cd9e','NEPTUNE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bcd7515e-dbfe-49ab-93b1-545d9ef2cd9e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '778c4698-8a3f-44b3-bdee-47b824242eef','OLSEN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '778c4698-8a3f-44b3-bdee-47b824242eef', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '637a4dd4-fe8f-4df7-82cc-1a5a09a43dc2','PALOMA',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '637a4dd4-fe8f-4df7-82cc-1a5a09a43dc2', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6b58666a-adce-4b1c-9ba0-63ca645fffa4','PALOMA/WAIWELA',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6b58666a-adce-4b1c-9ba0-63ca645fffa4', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '7958804f-507e-4a56-bb56-ff2d6b9762c9','PENFIELD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7958804f-507e-4a56-bb56-ff2d6b9762c9', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '32ef3980-8abd-4a0b-94ba-973eb07d4b83','PENGUIN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '32ef3980-8abd-4a0b-94ba-973eb07d4b83', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a59cd403-09a7-470b-9532-2d5d88f37972','PERMA-GLAS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a59cd403-09a7-470b-9532-2d5d88f37972', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '742336e2-98e5-4591-a48c-3803d73239f7','POLARIS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '742336e2-98e5-4591-a48c-3803d73239f7', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f147f081-3a4c-44a8-8d24-b98ba0099218','POWER MISER 12',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f147f081-3a4c-44a8-8d24-b98ba0099218', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '5769bbad-4e93-4b10-8458-61fdc1f080a4','PREMIER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '5769bbad-4e93-4b10-8458-61fdc1f080a4', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '45d73fec-5762-493c-bc57-c35679b674ad','PREMIER PLUS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '45d73fec-5762-493c-bc57-c35679b674ad', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a210f33c-f6d7-4e1c-b32e-b0e2ff4fe1eb','PRESTIGE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a210f33c-f6d7-4e1c-b32e-b0e2ff4fe1eb', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9fb03458-9399-422e-a8ad-71e18f2f508a','PRO TANKLESS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9fb03458-9399-422e-a8ad-71e18f2f508a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ce0283d9-d323-4d06-8055-acc24e450fdd','PRO-LINE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ce0283d9-d323-4d06-8055-acc24e450fdd', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8deb6291-5ca5-4123-83fa-ffe98094ed84','PROFESSIONAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8deb6291-5ca5-4123-83fa-ffe98094ed84', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '169c113b-c515-4d0f-afec-b4ec02880bea','PROLINE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '169c113b-c515-4d0f-afec-b4ec02880bea', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e8ae7515-4343-4b7b-bd0e-1490bafb835d','PROMAX',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e8ae7515-4343-4b7b-bd0e-1490bafb835d', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '4c29b09b-516f-48fe-aee1-6f961aa0cc44','QUAKER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '4c29b09b-516f-48fe-aee1-6f961aa0cc44', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '2d49fbbe-2303-4127-90c1-ec897d0fa902','QUICK-FLO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2d49fbbe-2303-4127-90c1-ec897d0fa902', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ddb0b870-312d-4dd6-9977-56a7b476b314','RAYPAK',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ddb0b870-312d-4dd6-9977-56a7b476b314', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '94203a12-6302-4dfe-a0bc-b89df78c3c31','RAYWALL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '94203a12-6302-4dfe-a0bc-b89df78c3c31', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a95bc16a-43e1-4285-ab6a-e98ea84dc15c','RELIANCE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a95bc16a-43e1-4285-ab6a-e98ea84dc15c', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e15947b3-f0bb-4bcd-b572-cc1b78992230','REVERE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e15947b3-f0bb-4bcd-b572-cc1b78992230', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '32ed07d1-bad5-49b6-975f-b16426694413','RHEEM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '32ed07d1-bad5-49b6-975f-b16426694413', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'ec638b59-6a66-4297-9987-090b8fc0d5a8','RHEEM-RUUD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'ec638b59-6a66-4297-9987-090b8fc0d5a8', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'RICHMOND' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6cdc2574-9529-4644-bdec-a9af938846f2', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'd10926a8-f8c3-4677-b718-829ae4586c99','RIVERIA',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'd10926a8-f8c3-4677-b718-829ae4586c99', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '7c3c017c-ece9-4c00-841d-0e069523f50a','SANDS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7c3c017c-ece9-4c00-841d-0e069523f50a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '12c076b5-4439-4ac5-acf9-844992edc826','SCOUT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '12c076b5-4439-4ac5-acf9-844992edc826', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f64f3fff-d928-4ee6-9189-b4e51972e058','SEARS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f64f3fff-d928-4ee6-9189-b4e51972e058', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '029bb8dd-10f4-423f-a193-c898811f921a','SELECT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '029bb8dd-10f4-423f-a193-c898811f921a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '91547c90-aa18-4a9b-92e7-fa5bef0dab23','SENTINAL',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '91547c90-aa18-4a9b-92e7-fa5bef0dab23', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '704c8957-539f-4793-8981-fd2b8aecdf4e','SEPCO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '704c8957-539f-4793-8981-fd2b8aecdf4e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '1212be95-537e-4281-ba38-fccd75b3342c','SERVISTAR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '1212be95-537e-4281-ba38-fccd75b3342c', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '2ded4c06-2e61-4037-8da0-e0a5a62863f7','SHAROCK',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '2ded4c06-2e61-4037-8da0-e0a5a62863f7', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '0cc8b322-1e1e-4e5c-817e-a229fad9e93a','SPECIAL DELUXE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '0cc8b322-1e1e-4e5c-817e-a229fad9e93a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '579f8a20-d6b8-44d7-97da-94300f3aafc1','STANDARD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '579f8a20-d6b8-44d7-97da-94300f3aafc1', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8db53b92-db5a-42c1-bd61-8d5253c0874e','STATE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8db53b92-db5a-42c1-bd61-8d5253c0874e', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9e952fa5-a0cd-4b7e-bb24-099314f11660','SUPER EAGLE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9e952fa5-a0cd-4b7e-bb24-099314f11660', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f655a514-4aa5-446a-ae25-63cc52339701','SUPER-FLO',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f655a514-4aa5-446a-ae25-63cc52339701', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '142aec37-be28-45b9-b4b7-24d83dbeec94','SUPER-STOR',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '142aec37-be28-45b9-b4b7-24d83dbeec94', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '28b49345-2f41-41bb-9f47-dd101ddde0b8','SUPERFLUE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '28b49345-2f41-41bb-9f47-dd101ddde0b8', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6a8ae35e-cf29-4426-bab4-cc0a4195f4be','SUPREME',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6a8ae35e-cf29-4426-bab4-cc0a4195f4be', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'bafcfdc9-fede-45cd-a615-cc9d1132d7e4','SURE COMFORT',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'bafcfdc9-fede-45cd-a615-cc9d1132d7e4', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'cfe9dfa0-997e-4fee-8240-cc0b454f1362','SURE-FIRE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'cfe9dfa0-997e-4fee-8240-cc0b454f1362', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'b29e25fa-b1ec-4b99-aca0-0f2ba3ffc12d','TAKAGI',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'b29e25fa-b1ec-4b99-aca0-0f2ba3ffc12d', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'a87a3caf-a18e-48c6-8e2c-6ca6932614f0','THE EARLS ENERGY',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'a87a3caf-a18e-48c6-8e2c-6ca6932614f0', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '6fb79692-9feb-4b7e-a35a-51e6df2e0b8a','THE ENERGY SAVER PLUS',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '6fb79692-9feb-4b7e-a35a-51e6df2e0b8a', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '224810b3-f146-4457-9439-112b5185a15d','THEMRM',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '224810b3-f146-4457-9439-112b5185a15d', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '7f1c98db-0b97-4aec-abb9-64d073d33398','THORO-CLEAN',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '7f1c98db-0b97-4aec-abb9-64d073d33398', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '617c656c-0d64-4d16-996c-0e9029ad86e8','TRU VALUE',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '617c656c-0d64-4d16-996c-0e9029ad86e8', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '8d71ef50-6fd5-4736-a96b-675c4f945273','TRUE-TEST',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '8d71ef50-6fd5-4736-a96b-675c4f945273', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '931fddff-848e-4ff8-8724-40affb803743','TTW',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '931fddff-848e-4ff8-8724-40affb803743', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( '9f5ebb01-7824-444a-b057-36a81574ac74','U.S. CRAFTMASTER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '9f5ebb01-7824-444a-b057-36a81574ac74', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'c17772b6-a023-479c-b265-3222fde9dcac','U.S.SUPPLY',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'c17772b6-a023-479c-b265-3222fde9dcac', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'e241062c-f3e4-4427-aafa-13d965b093f8','VANGUARD',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'e241062c-f3e4-4427-aafa-13d965b093f8', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
-- Skipping 'WHIRLPOOL' (already exists)
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( '16d1ba58-50f0-4dd2-be92-8dd3971b3696', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );
INSERT INTO equipment_manufacturers( id, name, created, modified ) 
VALUES( 'f6fd96f0-bf06-4e9b-9c2d-784423cd3367','XCL ENERGY SAVER',NOW(),NOW() );
INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) 
VALUES( 'f6fd96f0-bf06-4e9b-9c2d-784423cd3367', 'c48c9944-6f7f-11e0-be41-80593d270cc9', NOW(), NOW() );

SET foreign_key_checks = 1;
