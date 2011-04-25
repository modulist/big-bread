<?php $this->set( 'title_for_layout', __( 'My House', true ) ) ?>

<?php echo $this->Html->css( 'jqueryui/themes/aristo/jquery-ui-1.8.7.custom.css', null, array( 'inline' => false ) ) ?>

<?php echo $this->Form->create( 'Building' ) ?>
<?php # Really just a placeholder so that a Questionnaire record gets saved by saveAll() ?>
<?php echo $this->Form->input( 'Questionnaire.deleted', array( 'type' => 'hidden', 'value' => 0 ) ) ?>
<div id="general_Info">
  <div id="info">
    <div class="form">
      <div id="general_info">
        <h1 id="infohead"><?php __( 'General Information' ) ?></h1>
        <?php echo $this->Form->input( 'Client.first_name', array( 'label' => __( 'Client First Name', true ) ) ) ?>
        <?php echo $this->Form->input( 'Client.last_name', array( 'label' => __( 'Client Last Name', true ) ) ) ?>
        <?php echo $this->Form->input( 'Client.email', array( 'label' => __( 'Client Email', true ) ) ) ?>
        <?php echo $this->Form->input( 'Client.phone_number', array( 'label' => __( 'Client Phone Number', true ) ) ) ?>
        <?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'radio', 'legend' => false, 'default' => '4d71115d-0f74-43c5-93e9-2f8a3b196446' ) ) ?>
        
        <?php echo $this->Form->input( 'Address.address_1' ) ?>
        <?php echo $this->Form->input( 'Address.address_2' ) ?>
        <?php echo $this->Form->input( 'Address.zip_code' ) ?>
        
        <?php echo $this->element( '../buildings/_realtor_inputs' ) ?>
        <?php echo $this->element( '../buildings/_inspector_inputs' ) ?>
      </div> <!-- #general_info -->

      <div id="demographics">
        <h1><?php __( 'Demographics' ) ?></h1>
        <?php echo $this->element( '../buildings/_demographic_inputs' ) ?>
      </div> <!-- #demographics -->
      
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
  
      <div id="equipment_list">
        <h1><?php __( 'Equipment Listing' ) ?></h1>
        
        <fieldset class="group">
          <?php if( empty( $this->data['Product'] ) ): ?>
            <div class="cloneable">
              <?php echo $this->element( '../buildings/_building_product_inputs' ) ?>
            </div>
          <?php else: ?>
            <?php foreach( $this->data['Product'] as $i => $product ): ?>
              <div class="cloneable">
                <?php echo $this->Form->input( 'Product.' . $i . '.technology_id', array( 'label' => 'Equipment Type', 'required' => true, 'empty' => true ) ) ?>
                <?php echo $this->Form->input( 'Product.' . $i . '.make' ) # TODO: Make this an autocomplete field ?>
                <?php echo $this->Form->input( 'Product.' . $i . '.model' ) # TODO: Make this an autocomplete field ?>
                <?php echo $this->Form->input( 'Product.' . $i . '.energy_source_id', array( 'empty' => '' ) ) ?>
                <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.serial_number' ) ?>
                <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.notes' ) ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          
          <?php echo $this->Html->link( __( 'Add another piece of equipment', true ), '#', array( 'class' => 'clone' ) ) ?>
        </fieldset>
      </div> <!-- #equipment_list -->
  
      <div id="building_characteristics">
        <h2><?php __( 'Building Characteristics' ) ?></h2>
        <?php echo $this->Form->input( 'Building.exposure_type_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.year_built', array( 'placeholder' => 'Example: 1965' ) ) ?>
        <?php echo $this->Form->input( 'Building.finished_sf', array( 'placeholder' => 'Example: 4000 (no comma)' ) ) ?>
        <?php echo $this->Form->input( 'Building.building_type_id' ) ?>
        <?php echo $this->Form->input( 'Building.maintenance_level_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.stories_above_ground', array( 'placeholder' => 'Example: 2' ) ) ?>
        <?php echo $this->Form->input( 'Building.building_shape_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.basement_type_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.insulated_foundation' ) ?>
        <?php echo $this->Form->input( 'BuildingWallSystem.wall_system_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'BuildingWallSystem.insulation_level_id', array( 'empty' => true ) ) ?>
      </div> <!-- #building_characteristics -->
  
      <div id="building_envelope">
        <h2><?php __( 'Insulation, Windows &amp; Doors' ) ?></h2>
        
        <h3><?php __( 'Windows' ) ?></h3>
        <label>Window Pane Type</label>
        <?php echo $this->Form->input( 'BuildingWindowSystem.0.window_pane_type_id', array( 'type' => 'radio', 'legend' => false, 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'BuildingWindowSystem.0.tinted' ) ?>
        <?php echo $this->Form->input( 'BuildingWindowSystem.0.low_e' ) ?>
        <?php echo $this->Form->input( 'BuildingWindowSystem.0.frame_material_id', array( 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.window_percent_average', array( 'label' => __( 'Number of Average Size Windows (6-8 sf)', true ), 'placeholder' => __( 'Example: 10', true ) ) ) ?>
        <?php echo $this->Form->input( 'Building.window_percent_small', array( 'label' => __( 'Number of Small Windows (less than 6 sf)', true ), 'placeholder' => __( 'Example: 5', true ) ) ) ?>
        <?php echo $this->Form->input( 'Building.window_percent_large', array( 'label' => __( 'Number of Large Windows (more than 8 sf)', true ), 'placeholder' => __( 'Example: 2', true ) ) ) ?>
        <?php echo $this->Form->input( 'Building.window_wall' ) ?>
        <?php echo $this->Form->input( 'Building.window_wall_sf', array( 'label' => __( 'Estimated Size (sf)', true ), 'placeholder' => __( 'Example: 80', true ) ) ) ?>
        <?php echo $this->Form->radio( 'Building.window_wall_side', array( __( 'North', true ), __( 'South', true ), __( 'East', true ), __( 'West', true ) ), array( 'legend' => false ) ) ?>
        <?php echo $this->Form->input( 'Building.skylight_count', array( 'label' => __( 'Number of Skylights', true ), 'placeholder' => __( 'Example: 5', true ) ) ) ?>
      
        <?php echo $this->Form->input( 'Building.shading_type_id', array( 'label' => __( 'Sun Cover (lot &amp; interior)', true ), 'empty' => true ) ) ?>
         
        <h3><?php __( 'Air Tightness' ) ?></h3>
        <p>Check the box if there is evidence of:</p>
        <?php echo $this->Form->input( 'Building.drafts' ) ?>
        <?php echo $this->Form->input( 'Building.visible_weather_stripping' ) ?>
        <?php echo $this->Form->input( 'Building.visible_caulking' ) ?>
        <?php echo $this->Form->input( 'Building.windows_frequently_open' ) ?>
        
        <h3><?php __( 'Roof' ) ?></h3>
        <?php foreach( $roofSystems as $i => $roof_system ): ?>
          <?php if( !empty( $this->data['BuildingRoofSystem'] ) ): ?>
            <?php foreach( $this->data['BuildingRoofSystem'] as $building_roof ): ?>
              <?php $checked  = $building_roof['roof_system_id'] == $roof_system['RoofSystem']['id'] ? 'checked' : false; ?>
              <?php $coverage = $checked ? $building_roof['living_space_ratio'] : '' ?>
              
              <?php if( $checked ): ?>
                <?php break; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <?php $checked  = false ?>
            <?php $coverage = '' ?>
          <?php endif; ?>
          
          <?php echo $this->Form->checkbox(
            'BuildingRoofSystem.' . $i . '.roof_system_id',
            array( 'value' => $roof_system['RoofSystem']['id'], 'checked' => $checked )
          ) ?>
          <label for="BuildingRoofSystem<?php echo $i ?>RoofSystemId"><?php echo $roof_system['RoofSystem']['name'] ?></label>
          <?php echo $this->Form->input(
            'BuildingRoofSystem.' . $i . '.living_space_ratio',
            array( 'value' => $coverage, 'label' => __( 'Percentage of the total roof that is this shape', true ), 'placeholder' => __( 'Example: 100', true ) )
          ) ?>
        <?php endforeach; ?>
        
        <?php echo $this->Form->input( 'Building.roof_insulation_level_id', array( 'label' => __( 'Roof/Ceiling Insulation', true ), 'empty' => true ) ) ?>
        <?php echo $this->Form->input( 'Building.roof_radiant_barrier', array( 'type' => 'checkbox' ) ) ?>
      </div> <!-- #building_envelope -->
      
      <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
          <div class="button">
            <input type="submit" value="Submit" />
          </div>
      </div>
    </div> <!-- .form -->
  </div> <!-- #info -->
</div> <!-- #general_Info -->

<div id="questionnaire_act">
  <div class="clear"></div>
</div>
<?php echo $this->Form->end() ?>
