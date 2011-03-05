<h1>Home Survey</h1>

<?php echo $this->Form->create( 'Survey' ) ?>
  <h2>Contact Info</h2>
  <!-- #1 Realtor -->
  <?php echo $this->Form->input( 'Realtor.first_name', array( 'label' => 'Realtor First Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.last_name', array( 'label' => 'Realtor Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.email', array( 'label' => 'Realtor Email' ) ) ?>
  
  <!-- #2 Inspector -->
  <?php echo $this->Form->input( 'Inspector.first_name', array( 'label' => 'Inspector First Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.last_name', array( 'label' => 'Inspector Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.email', array( 'label' => 'Inspector Email' ) ) ?>
  
  <!-- #3 Homeowner -->
  <?php echo $this->Form->input( 'Client.first_name', array( 'label' => 'Client First Name' ) ) ?>
  <?php echo $this->Form->input( 'Client.last_name', array( 'label' => 'Client Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Client.email', array( 'label' => 'Client Email' ) ) ?>
  <!-- #6 Phone number -->
  <?php echo $this->Form->input( 'Client.phone_number' ) ?>
  <?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'radio', 'legend' => false, 'default' => '4d71115d-0f74-43c5-93e9-2f8a3b196446' ) ) ?>
  
  <!-- #5 Address -->
  <?php echo $this->Form->input( 'Address.address_1' ) ?>
  <?php echo $this->Form->input( 'Address.address_2' ) ?>
  <?php echo $this->Form->input( 'Address.city' ) # TODO: Populate city based on zip code ?>
  <?php echo $this->Form->input( 'Address.state' ) # TODO: Populate state based on zip coee ?>
  <?php echo $this->Form->input( 'Address.zip_code' ) ?>
  
  <h2>Demographics</h2>
  <!-- #7 Number of occupants by Age -->
  <?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => 'Ages 0-5' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => 'Ages 6-13' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => 'Ages 14-64' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => 'Ages 65+' ) ) ?>
  
  <!-- #8 Are occupants home during the day -->
  <?php echo $this->Form->input( 'Occupant.daytime_occupancy', array( 'label' => 'Are occupants at home during the day?' ) ) ?>
  
  <!-- #9 Heating and cooling setpoints and overrides -->
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_heating', array( 'label' => 'Thermostat setting (heating)' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.heating_override', array( 'label' => 'Frequently adjusted?' ) ) ?>
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_cooling', array( 'label' => 'Thermostat setting (cooling)' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.cooling_override', array( 'label' => 'Frequently adjusted?' ) ) ?>
  
  <p>Missing #10 (Utility providers) to be pulled from incentives database</p>
  
  <h2>Equipment Listing</h2>
  
  <?php foreach( $applianceTypes as $i => $type ): ?>
    <h3><?php echo h( $type['ApplianceType']['name'] ) ?></h3>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.appliance_type_id', array( 'type' => 'hidden', 'value' => $type['ApplianceType']['id'] ) ) ?>
    <?php echo $this->Form->input( 'Appliance.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Appliance.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.serial_number' ) ?>
    <?php echo $this->Form->input( 'Appliance.energy_source_id', array( 'empty' => 'Not Applicable' ) ) ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.year_built' ) ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.notes' ) ?>
  <?php endforeach; ?>
  
  <h2>Building Characteristics</h2>
  <!-- #20 Exposure to elements -->
  <?php echo $this->Form->input( 'Building.exposure_type_id' ) ?>
  <!-- #21 -->
  <?php echo $this->Form->input( 'Building.year_built' ) ?>
  <!-- #22 -->
  <?php echo $this->Form->input( 'Building.finished_sf' ) ?>
  <!-- #23 -->
  <?php echo $this->Form->input( 'Building.building_type_id' ) ?>
  <!-- #24 -->
  <?php echo $this->Form->input( 'Building.maintenance_level_id' ) ?>
  <!-- #25 -->
  <?php echo $this->Form->input( 'Building.stories_above_ground' ) ?>
  <?php echo $this->Form->input( 'Building.attic' ) ?>
  <!-- #26 -->
  <?php echo $this->Form->input( 'Building.building_shape_id' ) ?>
  <!-- #27 -->
  <?php echo $this->Form->input( 'Building.basement_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.insulated_foundation' ) ?>
  <!-- #28 -->
  <?php echo $this->Form->input( 'BuildingWallSystem.wall_system_id' ) ?>
  <!-- #29 -->
  <?php echo $this->Form->input( 'BuildingWallSystem.insulation_level_id' ) ?>
  
  <h2>Insulation, Windows &amp; Doors</h2>
  
  <p>Missing: #30 (Windows)</p>

  <!-- #31 -->
  <!-- window_wall_ratio doesn't feel right -->
  <?php echo $this->Form->input( 'Building.window_wall_ratio' ) ?>
  <?php echo $this->Form->input( 'Building.window_wall' ) ?>
  <?php echo $this->Form->input( 'Building.window_wall_sf', array( 'label' => 'Estimated Size (sf)' ) ) ?>
  <?php echo $this->Form->input( 'Building.window_wall_side' ) ?>
  <?php echo $this->Form->input( 'Building.skylight_count' ) ?>
  
  <!-- #32 Shading type -->
  <?php echo $this->Form->input( 'Building.shading_type_id' ) ?>
  
  <!-- #33 Infiltration -->
  <?php echo $this->Form->input( 'Building.drafts' ) ?>
  <?php echo $this->Form->input( 'Building.visible_weather_stripping' ) ?>
  <?php echo $this->Form->input( 'Building.visible_caulking' ) ?>
  <?php echo $this->Form->input( 'Building.windows_frequently_open' ) ?>
  
  <!-- #34 Percentage of roof shape over living space -->
  <?php echo $this->Form->input( 'BuildingRoofSystem.roof_system_id' ) ?>
  <?php echo $this->Form->input( 'BuildingRoofSystem.living_space_ratio' ) ?>
  
  <!-- #35 Roof/Ceiling Insulation -->
  <?php echo $this->Form->input( 'BuildingRoofSystem.insulation_level_id' ) ?>
  <?php echo $this->Form->input( 'BuildingRoofSystem.radiant_barrier' ) ?>
<?php echo $this->Form->end( 'Save' ) ?>

<!--
  - Separate Occupant.thermostat_overrides for heating cooling? NEEDS TO BE 2.
  - Question 10, utilities? Should these be free fields or ignored? Or are they energy_sources?
      -- In incentives database, there's a utility_boundaries table.
      -- Ideally a typeahead UX b/c only incentive providers are listed, not actual providers.
  - Are we planning to maintain an hvac product table as a lookup or just deal with those associated w/ a building?
  - Built-out attic == building_roof_id? What are the other options.
      -- BOOLEAN
  - Can a building have multiple wall types (i.e. wall systems)?
  - What is shading_type vs. exposure_type?
 -->
