USE @DB_NAME@;

SET foreign_key_checks = 0;

TRUNCATE TABLE glossary_terms;
INSERT INTO glossary_terms( id, foreign_key, model, definition ) VALUES
-- AC (no definition)
( '4dc6b55f-36ac-4ede-883e-dfbd6e891b5e', 'CACCHL', 'TechnologyOption', 'In a chilled water air conditioning system, cold water is flowing through a coil that cools the room''s air' ), -- Chiller
( '4dc6b55f-a8bc-470d-9dc5-dfbd6e891b5e', 'CACEV', 'TechnologyOption', 'An evaporative cooler (also swamp cooler, desert cooler, and wet air cooler) is a device that cools air through the simple evaporation of water' ),  -- Evaporative
( '4dc6d28a-5270-4d91-9199-e8496e891b5e', 'CACMS', 'TechnologyOption', 'A central air conditioning system using high velocity air forced through small ducts (also called mini-ducts)' ),  -- Mini-split
( '4dc6b55f-0de8-49a9-9296-dfbd6e891b5e', 'ACPACK', 'TechnologyOption', 'A packaged heating and air conditioning systems contain the same components you find in a typical split system together in one cabinet' ), -- AC Packaged
( '4dc6b55f-7184-4ba6-9edf-dfbd6e891b5e', 'ACSPLT', 'TechnologyOption', 'The condenser and compressor are located in an outdoor unit; the evaporator is mounted in the indoor air handler unit' ), -- AC Split

-- Boilers
( '4dc6b55f-cc88-4793-a7aa-dfbd6e891b5e', 'c48c6cda-6f7f-11e0-be41-80593d270cc9', 'Technology', 'A boiler is a closed vessel in which water or other fluid is heated.  The hot water or steam exits the boiler for heating applications.' ),
( '4dc6b97d-4754-431a-b142-e0e86e891b5e', 'BLCOND', 'TechnologyOption', 'A condensing boiler utilizes the latent heat of water produced from the burning of fuel to increase its efficiency' ), -- Condensing
( '4dc6b97d-a258-42bc-bfb9-e0e86e891b5e', 'BLHYD', 'TechnologyOption', 'A hydronic boiler operates by way of heating water/fluid and circulating that fluid throughout the home typically by way of radiators, baseboard heaters or through the floors' ),  -- Hydronic
( '4dc6b97d-f848-4336-bdc5-e0e86e891b5e', 'BLSTM', 'TechnologyOption', 'A steam boiler operates by way of heating water and circulating steam throughout the home typically by way of radiators, baseboard heaters or through the floors' ),  -- Steam

-- Ducts
( '4dc6b97d-4d70-4b0e-a73d-e0e86e891b5e', 'c48c7450-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Sheet metal tubes used in the transfer of air between spaces in a structure' ),

-- Furnace
( '4dc6b97d-a298-4d46-8052-e0e86e891b5e', 'FRNCON', 'TechnologyOption', 'Furnaces with efficiencies greater than approximately 89% extract so much heat from the exhaust that water vapor in the exhaust condenses; they are referred to as condensing furnaces' ), -- Condensing
( '4dc6b97d-f888-4525-a8df-e0e86e891b5e', 'FRNETS', 'TechnologyOption', 'High efficiency ETS systems take advantage of off peak power discounts (typically at night) by storing power in ceramic bricks or some other storage medium and discharging the heat throughout the day' ), -- ETS (Electric Thermal Storage)

-- Heat pumps
( '4dc6b97d-4e14-4728-a7aa-e0e86e891b5e', 'c48c7874-6f7f-11e0-be41-80593d270cc9', 'Technology', 'A heat pump is a machine or device that moves heat from one location (the "source") at a lower temperature to another location (the "sink" or "heat sink") at a higher temperature' ), -- Heat pump
-- ( '4dc6c101-3ad8-49c3-a3c4-e3256e891b5e', '', 'TechnologyOption', 'Extracts heat from air' ), -- Air source
-- ( '4dc6c101-9064-40ee-b68a-e3256e891b5e', '', 'TechnologyOption', 'Extracts heat from the ground or similar sources' ), -- Geothermal
-- ( '4dc6c101-e5f0-4005-8cce-e3256e891b5e', '', 'TechnologyOption', 'Body of water as a source of heat' ), -- Water source
( '4dc6b97d-a33c-4043-867b-e0e86e891b5e', 'HPPACK', 'TechnologyOption', 'Packaged heating and air conditioning systems contain the same components you find in a typical split system together in one cabinet' ), -- Packaged
( '4dc6b97d-f864-4e1c-bc0f-e0e86e891b5e', 'HPSPLT', 'TechnologyOption', 'The condenser and compressor are located in an outdoor unit; the evaporator is mounted in the indoor air handler unit' ), -- Split
-- ( '4dc6c101-3b18-4d16-82df-e3256e891b5e', '', 'TechnologyOption', 'The refrigerant in a geothermal heat pump exchanges heat directly with the soil through the walls of copper tubing installed in the ground' ), -- Direct exchange
( '4dc6bbf1-c41c-4650-b332-e1b16e891b5e', 'HPGCL', 'TechnologyOption', 'The primary refrigerant loop is contained in the appliance cabinet where it exchanges heat with a secondary water loop that is buried underground' ),  -- Closed loop
( '4dc6bbf1-2498-417a-96f7-e1b16e891b5e', 'HPGOL', 'TechnologyOption', 'In an open loop system (also called a groundwater heat pump), the secondary loop pumps natural water from a well or body of water into a heat exchanger inside the heat pump' ),  -- Open loop
( '4dc6bbf1-79c0-47b1-943e-e1b16e891b5e', 'HPMS', 'TechnologyOption', 'A central air conditioning system using high velocity air forced through small ducts (also called mini-ducts)' ),   -- Mini-split

-- House fans (can't find tech)
-- ( '4dc6c101-90a4-41a5-83db-e3256e891b5e', '', 'TechnologyOption', 'An attic fan is a ventilation fan that regulates the heat level of a building''s attic by exhausting hot air' ), -- Attic
-- ( '4dc6c101-e5cc-4c20-a0e5-e3256e891b5e', '', 'TechnologyOption', 'An evaporative cooler is a device that draws outside air through a wet pad, such as a large sponge soaked with water' ), -- Evaporative
-- ( '4dc6c101-3af4-4897-8dbc-e3256e891b5e', '', 'TechnologyOption', 'Heat recovery ventilation is an energy recovery ventilation system that employs a counter-flow heat exchanger between the inbound and outbound airflow' ), -- Heat recovery

-- Motors
( '4dc6b55f-8420-4b10-bf72-dfbd6e891b5e', 'c48c7ef0-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Fan motors in air conditioning and furnace air handlers' ),
( '4dc6bbf1-36d0-43c4-8d23-e1b16e891b5e', 'MOTECM', 'TechnologyOption', 'The ECM (Electronically Commutated Motor) uses less energy than the standard motor and offers more speed control, which has benefits in HVAC applications' ), -- ECM
( '4dc6bbf1-8cc0-4a71-a9ad-e1b16e891b5e', 'MOTVSM', 'TechnologyOption', 'A variable-speed motor is a system for controlling the rotational speed of the fan by matching the volume of air moved to system demand' ), -- VSM
-- Whole house fans
( '4dc6b55f-2728-46ba-aff6-dfbd6e891b5e', 'c48c99c6-6f7f-11e0-be41-80593d270cc9', 'Technology', 'A whole-house fan pulls hot air out of a building and forces it into the attic space' ),
( '4dc6bbf1-e24c-41f0-9ad4-e1b16e891b5e', 'WHFEVP', 'TechnologyOption', 'An evaporative cooler is a device that draws outside air through a wet pad, such as a large sponge soaked with water' ), -- Evaporative
( '4dc6bbf1-37d8-4590-960f-e1b16e891b5e', 'WHFHRV', 'TechnologyOption', 'Heat recovery ventilation is an energy recovery ventilation system that employs a counter-flow heat exchanger between the inbound and outbound airflow' ), -- Heat recovery

-- Space heaters (no definition)
( '4dc6bbf1-8d64-4526-bc3e-e1b16e891b5e', 'SHLII', 'TechnologyOption', 'An infrared heater uses electromagnetic radiation' ), -- Low intensity IR
( '4dc6bbf1-e354-44b8-bb63-e1b16e891b5e', 'SHETS', 'TechnologyOption', 'High efficiency ETS systems take advantage of off peak power discounts by storing power in ceramic bricks or some other storage medium and converting to heat throughout the day' ), -- ETS
( '4dc6bbf1-387c-4840-87f2-e1b16e891b5e', 'SHFP', 'TechnologyOption', 'Gas insert' ),  -- Fireplace
-- System controls (no definition)
-- ( '4dc6bde0-c018-44ca-8946-e23a6e891b5e', '', 'TechnologyOption', 'Automatically adjusts the burner run pattern to match the system''s heat load, substantially improving efficiency' ), -- Boiler controls
-- ( '4dc6bde0-21c0-4da2-a9e6-e23a6e891b5e', '', 'TechnologyOption', 'Mechanical device that is designed to reduce energy consumption on HVAC equipment' ), -- Dual enthalpy economizer

-- Water heaters (no definition)
( '4dc6bde0-77b0-4327-beef-e23a6e891b5e', 'WHCND', 'TechnologyOption', 'The exhaust flue spirals around inside the tank so that the combustion gases spend more time releasing the heat until the water vapor in the gas,a natural by-product of the combustion process, condenses, releasing even more energy. ' ), -- Condensing
-- ( '4dc6bde0-2584-4327-ad26-e23a6e891b5e', '', 'TechnologyOption', 'A small, auxiliary heat exchanger that uses superheated gases from the heat pump''s compressor to heat water. This hot water then circulates through a pipe to the home's storage water heater tank.' ), -- Desuperheater
( '4dc6bde0-ce68-4fe0-aa37-e23a6e891b5e', 'WHHP', 'TechnologyOption', 'Uses electricity to move heat from one place to another. Heat pumps work like a refrigerator in reverse if you''re heating water.	' ), -- Heat pump
( '4dc6bde0-7ca0-4ffd-a3e7-e23a6e891b5e', 'WHIND', 'TechnologyOption', 'An indirect water heater uses the main furnace or boiler to heat a fluid that''s circulated through a heat exchanger in the storage tank' ), -- Indirect
( '4dc6bde0-d420-43de-9dc6-e23a6e891b5e', 'WHPVNT', 'TechnologyOption', 'A gas water heater needs a device to move the harmful exhaust gases out of the house; That device is a small motor that mounts right on top of the water heater tank.' ), -- Power vented
( '4dc6bde0-2948-451c-aca0-e23a6e891b5e', 'WHTNK', 'TechnologyOption', 'Stores heated water' ), -- Tank
( '4dc6bde0-7ed4-4529-aac4-e23a6e891b5e', 'WHTKL', 'TechnologyOption', 'Heats water on demand across gas or electric burners' ), -- Tankless

-- Water heater insulation
( '4dc6b55f-df88-4e86-b402-dfbd6e891b5e', 'c48c9a34-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Insulation blanket that wraps around the water heater tank' ),

-- Drain water heat recovery
( '4dc6b55f-3c1c-4202-95b7-dfbd6e891b5e', 'c48c7360-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Capture the heat in wastewater to preheat cold water entering the water heater or going to other water fixtures' ),

-- Building control systems (no definition)
( '4dc6bf6c-cd90-4fc9-a1fd-e2b46e891b5e', 'CTRED', 'TechnologyOption', 'A device that controls your major electric appliances in order to limit the peak energy use in your home' ), -- Electronic demand controller
-- ( '4dc6bf6c-2e0c-4474-a1c4-e2b46e891b5e', '', 'TechnologyOption', 'Stops the idle current drawn from your outlets when electronics aren''t in use' ), -- Smart power strips

-- Programmable thermostats
( '4dc6b55f-9658-45de-a4ed-dfbd6e891b5e', 'c48c8ee0-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Adjust the times you turn on the heating or air-conditioning according to a pre-set schedule' ),
( '4dc6bf6c-c088-4c84-8d17-e2b46e891b5e', 'PTMZ', 'TechnologyOption', 'Designed for a 2, 3 or 4 zone system that can be applied to single or multi-stage heat/cool equipment or single or multi-stage heat pumps' ), -- Multi-zone

-- Pool pumps
( '4dc6bf6c-6a74-4a3b-9dd8-e2b46e891b5e', 'PPVSM', 'TechnologyOption', 'a variable-speed motor controls the rotational speed of the fan by matching the volume of water moved to system demand' ), -- Variable speed

-- Dryers
( '4dc6bf6c-c12c-40d9-a823-e2b46e891b5e', 'DRMS', 'TechnologyOption', 'Automatically stop the machine when the laundry is dry' ), -- Moisture sensor

-- Wall
( '4dc6bf6c-16b8-4a9b-9ca1-e2b46e891b5e', 'INFND', 'TechnologyOption', 'Insulation that would fit in each bay between the floor joists under your flooring' ), -- Foundation
( '4dc6bf6c-6c44-49a4-800e-e2b46e891b5e', 'INRB', 'TechnologyOption', 'Barriers consist of a highly reflective material that reflects the sunÕs rays away from the attic rather than absorbing it into the house' ),  -- Radiant barrier

-- Air Sealing
( '4dc6b97d-e610-419f-ae73-e0e86e891b5e', 'c48c6a5a-6f7f-11e0-be41-80593d270cc9', 'Technology', 'Blocks outside air from entering a house uncontrollably through cracks and openings' ),

-- Roofs
( '4dc6bf6c-c16c-40ad-a1af-e2b46e891b5e', 'ROOFR', 'TechnologyOption', 'White or special reflective pigments that reflects sunlight' ),

-- Windows
-- ( '4dc6bf6c-6c20-41c0-9d88-e2b46e891b5e', '', 'TechnologyOption', 'Used for transporting or distributing natural or artificial light' ), -- Light tubes

-- Whole building measures
( '4dc6c101-e4e8-4873-944b-e3256e891b5e', 'WBAUD', 'TechnologyOption', 'An energy inspection of your home and identification of ways to save energy' ), -- Audit
-- ( '4dc6c101-846c-463e-9952-e3256e891b5e', '', 'TechnologyOption', 'A comprehensive whole-house approach to identifying and fixing comfort and energy efficiency problems in a home' ), -- Home performance

-- Terms
( '4dc732b2-a8b8-44b3-8421-44496e891b5e', 'AFUE', 'TechnologyTerm', 'A thermal efficiency measure of combustion equipment like furnaces, boilers, and water heaters.  The higher the number, the greater the efficiency' ),
-- ( '4dc732b2-39a4-4e4f-bb35-45926e891b5e', '', 'TechnologyTerm', 'Approximately the amount of energy needed to heat 1 pound of water from 39&deg; F to 40&deg; F' ), -- BTU
( '4dc732b2-bc80-42c2-acfa-436a6e891b5e', 'BTUH', 'TechnologyTerm', 'Used as a measurement for sizing the capacity of a piece of heating or cooling equipment' ),
( '4dc732b2-4470-4f72-b92a-47d96e891b5e', 'CAE', 'TechnologyTerm', 'Combined Appliance Efficiency Rating (CAE) used to measure the efficiency of integrated space heating and hot water (combined furnace and hot water system)' ),
-- ( '4dc732b2-bbf8-45da-8c6f-4b436e891b5e', '', 'TechnologyTerm', 'Consortium for Energy Efficiency energy performance rankings.  The higher the more efficient.' ), -- CEE tiers
-- ( '4dc732b2-bbf8-45da-8c6f-4b436e891b5e', '', 'TechnologyTerm', 'cubic feet per minute' ), -- CFM
( '4dc732b2-2e6c-484d-85d4-4b606e891b5e', 'CONGE', 'TechnologyTerm', 'Conversion of existing equipment from natural gas to electric' ),
( '4dc732b2-a0e0-49c5-83d7-4cc06e891b5e', 'CONEG', 'TechnologyTerm', 'Conversion of existing equipment from electric to natural gas' ),
-- ( '4dc732b2-1354-4f46-ad57-424c6e891b5e', '', 'TechnologyTerm', 'Conversion of existing equipment from heating oil to natural gas' ),
-- ( '4dc732b2-8564-4ec5-aba3-44006e891b5e', '', 'TechnologyTerm', 'Conversion of existing equipment from heating oil to electric' ),
-- ( '4dc732b2-f7d8-403b-93de-4a426e891b5e', '', 'TechnologyTerm', 'Conversion of equipment from any fuel to natural gas' ),
-- ( '4dc73506-0780-4000-a04b-41ea6e891b5e', '', 'TechnologyTerm', 'Conversion of equipment from propane to natural gas' ),
-- ( '4dc73506-66d0-4fbc-9166-4dc56e891b5e', '', 'TechnologyTerm', 'Conversion of equipment from propane to electric' ),
-- ( '4dc73506-bd24-45e4-b78c-445a6e891b5e', '', 'TechnologyTerm', 'The coefficient of performance of a heat pump is the ratio of the change in heat at the "output" to the supplied work; the higher the number, the higher the performance of the equipment' ), -- COP
( '4dc73506-1440-4cb6-b288-4a916e891b5e', 'EER', 'TechnologyTerm', 'The Energy Efficiency Ratio (EER) of a particular cooling device is the ratio of output cooling (in Btu/hr) to input electrical power (in Watts); the higher the number the greater the performance of the equipment' ), -- EER
( '4dc73506-2740-494c-94b9-4b606e891b5e', 'EF', 'TechnologyTerm', 'The higher the "Energy Factor" number, the more efficient the water heater. Gas water heaters have energy factors between 0.5 to around 0.7. Electric models range from 0.75 to 0.95.' ), -- EF
( '4dc73506-7fec-4329-b685-4c346e891b5e', 'FE', 'TechnologyTerm', 'A measure of how efficient the equipment is in converting the energy found in the fuel to actual output.  The higher the number, the more energy is extracted from the fuel making it more cost effective for the user.' ), -- FE
( '4dc73506-e1f8-4bef-bccf-4db76e891b5e', 'HSPF', 'TechnologyTerm', 'Most commonly used measure of the heating efficiency of heat pumps.  The most efficient heat pumps have an HSPF of 10.  The higher the more efficient the unit.' ), -- HSPF
( '4dc73506-4850-4937-b4a9-41316e891b5e', 'KW', 'TechnologyTerm', 'A measure of electric power' ), -- kW
( '4dc73506-9f6c-44cd-b7f4-4ce26e891b5e', 'KWHY', 'TechnologyTerm', 'A measure of electric power consumer in a year' ), -- kWh/yr
( '4dc73a5d-2d20-418a-9c69-41f46e891b5e', 'MBH', 'TechnologyTerm', 'Thousand BTU''s Per Hour' ), -- MBH
( '4dc73506-f5c0-4658-af84-446a6e891b5e', 'MEF', 'TechnologyTerm', 'MEF considers the energy used to run the washer, heat the water, and run the dryer. The higher the MEF, the more efficient the clothes washer.' ),
( '4dc736d5-1cb0-4350-8ec8-4b796e891b5e', 'NEWCON', 'TechnologyTerm', 'Available for newly built homes' ), -- New construction
( '4dc736d5-7d90-4371-92f5-4a3e6e891b5e', 'NEWSYS', 'TechnologyTerm', 'Must be a system new to the home versus a replacement of a similar unit' ),
( '4dc736d5-d3e4-44e8-b512-4e1e6e891b5e', 'RVAL', 'TechnologyTerm', 'A measure of thermal resistance of the building' ), -- R-Value
( '4dc736d5-2a38-4354-b603-40e56e891b5e', 'REPL', 'TechnologyTerm', 'Rebate applies to replacement of existing equipment in an existing building' ), -- Replacement
( '4dc736d5-80f0-4f5e-82e3-4b136e891b5e', 'SEER', 'TechnologyTerm', 'The higher the unit''s SEER rating the more energy efficient it is' ), -- SEER
( '4dc736d5-d744-47bc-9337-44946e891b5e', 'SEF', 'TechnologyTerm', 'The solar energy factor is defined as the energy delivered by the system divided by the electrical or gas energy put into the system. The higher the number, the more energy efficient.' ), -- SEF
( '4dc736d5-2d98-48ed-b0e5-491b6e891b5e', 'SRI', 'TechnologyTerm', 'A solar reflective index value indicates that the surface absorbs all solar radiation, and a value of 1 represents total reflectivity.' ), -- SRI
( '4dc736d5-8388-43f9-aafe-4c1b6e891b5e', 'TE', 'TechnologyTerm', 'The thermal efficiency ratio measures the amount of heat output of a device versus the energy input.  The higher the number the greater the efficiency.' ), -- TE
( '4dc736d5-d9dc-4d39-b53a-41146e891b5e', 'UVAL', 'TechnologyTerm', 'Describes how well a building element conducts heat.  The lower the number the less conductive and higher the benefit.' ), -- U-Value
( '4dc736d5-2fcc-4226-ad95-4baf6e891b5e', 'UE', 'TechnologyTerm', 'Use efficiency identifies the water use efficiency in an appliance such as a clothes washer.  The higher the number the greater the efficiency.' ),
( '4dc73821-5618-45c8-9184-41ac6e891b5e', 'WRNTY', 'TechnologyTerm', 'The number of years the manufacturer warrants the system' ), -- Warranty
( '4dc73821-b504-4371-a85b-49e16e891b5e', 'WF', 'TechnologyTerm', 'Water Factor is a measurement of water efficiency.  The lower the WF, the more efficient the clothes washer.' ); -- Water factor

UPDATE glossary_terms
   SET created = NOW(),
       modified = NOW();

-- TODO: Insert updated search_view script

SET foreign_key_checks = 1;
