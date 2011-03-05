<h1>Home Survey</h1>

<?php echo $this->Form->create( 'Survey' ) ?>
  <h2>Contact Info</h2>
  <?php echo $this->Form->input( 'Realtor.first_name', array( 'label' => 'Realtor First Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.last_name', array( 'label' => 'Realtor Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.email', array( 'label' => 'Realtor Email' ) ) ?>
  
  <?php echo $this->Form->input( 'Inspector.first_name', array( 'label' => 'Inspector First Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.last_name', array( 'label' => 'Inspector Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.email', array( 'label' => 'Inspector Email' ) ) ?>
  
  <?php echo $this->Form->input( 'Client.first_name', array( 'label' => 'Client First Name' ) ) ?>
  <?php echo $this->Form->input( 'Client.last_name', array( 'label' => 'Client Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Client.email', array( 'label' => 'Client Email' ) ) ?>
  <?php echo $this->Form->input( 'Client.phone_number' ) ?>
  <?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'radio', 'legend' => false, 'default' => '4d71115d-0f74-43c5-93e9-2f8a3b196446' ) ) ?>
  
  <?php echo $this->Form->input( 'Address.address_1' ) ?>
  <?php echo $this->Form->input( 'Address.address_2' ) ?>
  <?php echo $this->Form->input( 'Address.city' ) # TODO: Populate city based on zip code ?>
  <?php echo $this->Form->input( 'Address.state' ) # TODO: Populate state based on zip coee ?>
  <?php echo $this->Form->input( 'Address.zip_code' ) ?>
  
  <h2>Demographics</h2>
  <?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => 'Ages 0-5' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => 'Ages 6-13' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => 'Ages 14-64' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => 'Ages 65+' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.daytime_occupancy', array( 'label' => 'Are occupants at home during the day?' ) ) ?>
  
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_heating', array( 'label' => 'Thermostat setting (heating)' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.heating_override', array( 'label' => 'Frequently adjusted?' ) ) ?>
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_cooling', array( 'label' => 'Thermostat setting (cooling)' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.cooling_override', array( 'label' => 'Frequently adjusted?' ) ) ?>
  
  <p>Missing #10 (Utility providers) to be pulled from incentives database</p>
  
  <h2>Equipment Listing</h2>
  
  <h3>HVAC Systems</h3>
  
  <h4>Furnace or Boiler</h4>
  <fieldset class="cloneable first">
    <?php echo $this->Form->input( 'HvacSystem.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'HvacSystem.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.0.serial_number' ) ?>
    <?php echo $this->Form->input( 'HvacSystem.energy_source_id', array( 'empty' => 'Not Applicable' ) ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.0.year_built' ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.0.notes' ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.0.space_heaters', array( 'Space heaters present?' ) ) ?>
  </fieldset>
  
  <h4>Cooling System</h4>
  <fieldset class="cloneable odd last">
    <?php echo $this->Form->input( 'HvacSystem.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'HvacSystem.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.1.serial_number' ) ?>
    <?php echo $this->Form->input( 'HvacSystem.energy_source_id', array( 'empty' => 'Not Applicable' ) ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.1.year_built' ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.1.notes' ) ?>
    <?php echo $this->Form->input( 'BuildingHvacSystem.1.room_ac', array( 'label' => 'Room air conditioners present?' ) ) ?>
  </fieldset>
  
  <h3>Hot Water System</h3>
  <fieldset class="cloneable first">
    <?php echo $this->Form->input( 'HotWaterSystem.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'HotWaterSystem.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'BuildingHotWaterSystem.0.serial_number' ) ?>
    <?php echo $this->Form->input( 'HotWaterSystem.energy_source_id', array( 'empty' => 'Not Applicable' ) ) ?>
    <?php echo $this->Form->input( 'BuildingHotWaterSystem.0.year_built' ) ?>
    <?php echo $this->Form->input( 'BuildingHotWaterSystem.0.notes' ) ?>
  </fieldset>
  
  <h3>Appliances</h3>
  <?php foreach( $applianceTypes as $i => $type ): ?>
    <h4><?php echo h( $type['ApplianceType']['name'] ) ?></h4>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.appliance_type_id', array( 'type' => 'hidden', 'value' => $type['ApplianceType']['id'] ) ) ?>
    <?php echo $this->Form->input( 'Appliance.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Appliance.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.serial_number' ) ?>
    <?php echo $this->Form->input( 'Appliance.energy_source_id', array( 'empty' => 'Not Applicable' ) ) ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.year_built' ) ?>
    <?php echo $this->Form->input( 'BuildingAppliance.' . $i . '.notes' ) ?>
  <?php endforeach; ?>
  
  <h2>Building Characteristics</h2>
  <?php echo $this->Form->input( 'Building.exposure_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.year_built' ) ?>
  <?php echo $this->Form->input( 'Building.finished_sf' ) ?>
  <?php echo $this->Form->input( 'Building.building_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.maintenance_level_id' ) ?>
  <?php echo $this->Form->input( 'Building.stories_above_ground' ) ?>
  <?php echo $this->Form->input( 'Building.built_out_attic' ) ?>
  <?php echo $this->Form->input( 'Building.building_shape_id' ) ?>
  <?php echo $this->Form->input( 'Building.basement_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.insulated_foundation' ) ?>
  <?php echo $this->Form->input( 'BuildingWallSystem.wall_system_id' ) ?>
  <?php echo $this->Form->input( 'BuildingWallSystem.insulation_level_id' ) ?>
  
  <h2>Insulation, Windows &amp; Doors</h2>
  
  <h3>Windows</h3>
  <?php echo $this->Form->input( 'BuildingWindowSystem.window_systems', array( 'multiple' => 'checkbox' ) ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_average', array( 'label' => 'Average (6-8 sf)' ) ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_small', array( 'label' => 'Few/Small (less than 6 sf, low natural light)' ) ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_large', array( 'label' => 'Large (more than 8 sf, bright natural light)' ) ) ?>
  <?php echo $this->Form->input( 'Building.window_wall' ) ?>
  <?php echo $this->Form->input( 'Building.window_wall_sf', array( 'label' => 'Estimated Size (sf)' ) ) ?>
  <?php echo $this->Form->radio( 'Building.window_wall_side', array( 'North', 'South', 'East', 'West' ), array( 'legend' => false ) ) ?>
  <?php echo $this->Form->input( 'Building.skylight_count' ) ?>

  <?php echo $this->Form->input( 'Building.shading_type_id', array( 'label' => 'Sun Cover (lot &amp; interior)' ) ) ?>
  
  <?php echo $this->Form->input( 'Building.drafts' ) ?>
  <?php echo $this->Form->input( 'Building.visible_weather_stripping' ) ?>
  <?php echo $this->Form->input( 'Building.visible_caulking' ) ?>
  <?php echo $this->Form->input( 'Building.windows_frequently_open' ) ?>
  
  <!-- #34 Percentage of roof shape over living space -->
  <?php foreach( $roofSystems as $i => $roof_system ): ?>
    <?php echo $this->Form->checkbox( 'BuildingRoofSystem.' . $i . '.roof_system_id', array( 'value' => $roof_system['RoofSystem']['id'] ) ) ?>
    <label for="BuildingRoofSystem<?php echo $i ?>RoofSystemId"><?php echo $roof_system['RoofSystem']['name'] ?></label>
    <?php echo $this->Form->input( 'BuildingRoofSystem.' . $i . '.living_space_ratio' ) ?>
  <?php endforeach; ?>
  
  <!-- #35 Roof/Ceiling Insulation -->
  <?php echo $this->Form->input( 'BuildingRoofSystem.insulation_level_id', array( 'label' => 'Roof/Ceiling Insulation' ) ) ?>
  <?php echo $this->Form->input( 'BuildingRoofSystem.radiant_barrier' ) ?>
<?php echo $this->Form->end( 'Save' ) ?>
