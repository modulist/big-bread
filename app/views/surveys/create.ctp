<?php $this->set( 'title_for_layout', __( 'Questionnaire', true )) ?>
<?php echo $this->Html->css( 'jqueryui/themes/jquery-ui-1.8.10.custom.css', null, array( 'inline' => false ) ) ?>

<h1><?php __( 'Questionnaire' ) ?></h1>

<?php echo $this->Form->create( 'Survey' ) ?>
  <h2><?php __( 'Contact Info' ) ?></h2>
  <?php echo $this->Form->input( 'Realtor.first_name', array( 'label' => __( 'Realtor First Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Realtor.last_name', array( 'label' => __( 'Realtor Last Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Realtor.email', array( 'label' => __( 'Realtor Email', true ) ) ) ?>
  
  <?php echo $this->Form->input( 'Inspector.first_name', array( 'label' => __( 'Inspector First Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Inspector.last_name', array( 'label' => __( 'Inspector Last Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Inspector.email', array( 'label' => __( 'Inspector Email', true ) ) ) ?>
  
  <?php echo $this->Form->input( 'Client.first_name', array( 'label' => __( 'Client First Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Client.last_name', array( 'label' => __( 'Client Last Name', true ) ) ) ?>
  <?php echo $this->Form->input( 'Client.email', array( 'label' => __( 'Client Email', true ) ) ) ?>
  <?php echo $this->Form->input( 'Client.phone_number', array( 'label' => __( 'Client Phone Number', true ) ) ) ?>
  <?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'radio', 'legend' => false, 'default' => '4d71115d-0f74-43c5-93e9-2f8a3b196446' ) ) ?>
  
  <?php echo $this->Form->input( 'Address.address_1' ) ?>
  <?php echo $this->Form->input( 'Address.address_2' ) ?>
  <?php echo $this->Form->input( 'Address.zip_code' ) ?>
  
  <h2><?php __( 'Demographics' ) ?></h2>
  <?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => __( 'Ages 0-5', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => __( 'Ages 6-13', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => __( 'Ages 14-64', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => __( 'Ages 65+', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.daytime_occupancy', array( 'label' => __( 'Are occupants at home during the day?', true ) ) ) ?>
  
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_heating', array( 'label' => __( 'Thermostat setting (heating)', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.heating_override', array( 'label' => __( 'Frequently adjusted?', true ) ) ) ?>
  <?php echo $this->Form->input( 'BuildingHvacSystem.setpoint_cooling', array( 'label' => __( 'Thermostat setting (cooling)', true ) ) ) ?>
  <?php echo $this->Form->input( 'Occupant.cooling_override', array( 'label' => __( 'Frequently adjusted?', true ) ) ) ?>
  
  <div id="utility-providers" style="display: none;">
    <h3><?php __( 'Utility Providers' ) ?></h3>
    <?php echo $this->Form->input( 'Building.electricity_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.electricity_provider_id', array( 'type' => 'hidden' ) ) ?>
    
    <?php echo $this->Form->input( 'Building.gas_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.gas_provider_id', array( 'type' => 'hidden' ) ) ?>
    
    <?php echo $this->Form->input( 'Building.water_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.water_provider_id', array( 'type' => 'hidden' ) ) ?>
    
    <h4><?php __( 'Alternative Heating Source' ) ?></h4>
    <?php echo $this->Form->input( 'Building.other_heating_source', array( 'type' => 'radio', 'options' => array( 'PROPANE' => 'Propane', 'HEATING OIL' => 'Heating Oil', 'OTHER' => 'Other' ), 'legend' => false ) ) ?>
  </div>
    
  <h2><?php __( 'Equipment Listing' ) ?></h2>
  
  <fieldset class="group">
    <div class="cloneable">
      <?php echo $this->Form->input( 'Product.0.technology_id', array( 'label' => 'Equipment Type', 'required' => true, 'empty' => true ) ) # TODO: Make this an autocomplete field ?>
      <?php echo $this->Form->input( 'Product.0.make' ) # TODO: Make this an autocomplete field ?>
      <?php echo $this->Form->input( 'Product.0.model' ) # TODO: Make this an autocomplete field ?>
      <?php echo $this->Form->input( 'BuildingProduct.0.serial_number' ) ?>
      <?php # echo $this->Form->input( 'Product.0.energy_source_id', array( 'empty' => __( 'Not Applicable', true ) ) ) ?>
      <?php echo $this->Form->input( 'BuildingProduct.0.notes' ) ?>
    </div>
    
    <?php echo $this->Html->link( __( 'Add another piece of equipment', true ), '#', array( 'class' => 'clone' ) ) ?>
  </fieldset>
  
  <h2><?php __( 'Building Characteristics' ) ?></h2>
  <?php echo $this->Form->input( 'Building.exposure_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.year_built' ) ?>
  <?php echo $this->Form->input( 'Building.finished_sf' ) ?>
  <?php echo $this->Form->input( 'Building.building_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.maintenance_level_id' ) ?>
  <?php echo $this->Form->input( 'Building.stories_above_ground' ) ?>
  <?php echo $this->Form->input( 'Building.building_shape_id' ) ?>
  <?php echo $this->Form->input( 'Building.basement_type_id' ) ?>
  <?php echo $this->Form->input( 'Building.insulated_foundation' ) ?>
  <?php echo $this->Form->input( 'BuildingWallSystem.wall_system_id' ) ?>
  <?php echo $this->Form->input( 'BuildingWallSystem.insulation_level_id' ) ?>
  
  <h2><?php __( 'Insulation, Windows &amp; Doors' ) ?></h2>
  
  <h3><?php __( 'Windows' ) ?></h3>
  <label>Window Pane Type</label>
  <?php echo $this->Form->input( 'BuildingWindowSystem.0.window_pane_type_id', array( 'type' => 'radio', 'legend' => false ) ) ?>
  <?php echo $this->Form->input( 'BuildingWindowSystem.0.tinted' ) ?>
  <?php echo $this->Form->input( 'BuildingWindowSystem.0.low_e' ) ?>
  <?php echo $this->Form->input( 'BuildingWindowSystem.0.frame_material_id' ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_average', array( 'label' => __( 'Average (6-8 sf)', true ) ) ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_small', array( 'label' => __( 'Few/Small (less than 6 sf, low natural light)', true ) ) ) ?>
  <?php echo $this->Form->input( 'Building.window_percent_large', array( 'label' => __( 'Large (more than 8 sf, bright natural light)', true ) ) ) ?>
  <?php echo $this->Form->input( 'Building.window_wall' ) ?>
  <?php echo $this->Form->input( 'Building.window_wall_sf', array( 'label' => __( 'Estimated Size (sf)', true ) ) ) ?>
  <?php echo $this->Form->radio( 'Building.window_wall_side', array( __( 'North', true ), __( 'South', true ), __( 'East', true ), __( 'West', true ) ), array( 'legend' => false ) ) ?>
  <?php echo $this->Form->input( 'Building.skylight_count' ) ?>

  <?php echo $this->Form->input( 'Building.shading_type_id', array( 'label' => __( 'Sun Cover (lot &amp; interior)', true ) ) ) ?>
  
  <h3><?php __( 'Air Tightness' ) ?></h3>
  <?php echo $this->Form->input( 'Building.drafts' ) ?>
  <?php echo $this->Form->input( 'Building.visible_weather_stripping' ) ?>
  <?php echo $this->Form->input( 'Building.visible_caulking' ) ?>
  <?php echo $this->Form->input( 'Building.windows_frequently_open' ) ?>
  
  <h3><?php __( 'Roof' ) ?></h3>
  <?php foreach( $roofSystems as $i => $roof_system ): ?>
    <?php echo $this->Form->checkbox( 'BuildingRoofSystem.' . $i . '.roof_system_id', array( 'value' => $roof_system['RoofSystem']['id'] ) ) ?>
    <label for="BuildingRoofSystem<?php echo $i ?>RoofSystemId"><?php echo $roof_system['RoofSystem']['name'] ?></label>
    <?php echo $this->Form->input( 'BuildingRoofSystem.' . $i . '.living_space_ratio' ) ?>
  <?php endforeach; ?>
  
  <?php echo $this->Form->input( 'BuildingRoofSystem.insulation_level_id', array( 'label' => __( 'Roof/Ceiling Insulation', true ) ) ) ?>
  <?php echo $this->Form->input( 'BuildingRoofSystem.radiant_barrier' ) ?>
<?php echo $this->Form->end( 'Save' ) ?>
