<?php $this->set( 'title_for_layout', __( 'My House', true ) ) ?>

<?php echo $this->Html->script( array( 'jquery/jquery.editable-1.3.3.min.js' ), array( 'inline' => false ) ) ?>
<?php echo $this->Html->css( 'jqueryui/themes/aristo/jquery-ui-1.8.7.custom.css', null, array( 'inline' => false ) ) ?>

<?php echo $this->element( 'building_info', array( 'edit' => true ) ) ?>

<div id="general_Info">
  <div id="info">
    <div class="sliding-panel" id="realtor">
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'realtor' ) ) ) ?>
        <?php echo $this->element( '../buildings/_realtor_inputs' ) ?>
        <div class="buttons">
            <div class="button">
              <input type="submit" value="Change" />
            </div>
            <div class="button">
              <input type="reset" value="Cancel" />
            </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div>
    <div class="sliding-panel" id="inspector">
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'inspector' ) ) ) ?>
        <?php echo $this->element( '../buildings/_inspector_inputs' ) ?>
        <div class="buttons">
            <div class="button">
              <input type="submit" value="Change" />
            </div>
            <div class="button">
              <input type="reset" value="Cancel" />
            </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div>
    
    <div id="demographics">
      <h1><?php __( 'Demographics' ) ?></h1>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'occupant' ) ) ) ?>
      <?php echo $this->Form->input( 'Occupant.id' ) ?>
      <ul>
        <li>
          <label>Number of occupants age 0-5</label>
          <div class="editable" data-model="Occupant" data-field="age_0_5"><?php echo !empty( $this->data['Occupant']['age_0_5'] ) ? $this->data['Occupant']['age_0_5'] : 0 ?></div>
        </li>
        <li>
          <label>Number of occupants age 6-13</label>
          <div class="editable" data-model="Occupant" data-field="age_6_13"><?php echo !empty( $this->data['Occupant']['age_6_13'] ) ? $this->data['Occupant']['age_6_13'] : 0 ?></div>
        </li>
        <li>
          <label>Number of occupants age 14-64</label>
          <div class="editable" data-model="Occupant" data-field="age_14_64"><?php echo !empty( $this->data['Occupant']['age_14_64'] ) ? $this->data['Occupant']['age_14_64'] : 0 ?></div>
        </li>
        <li>
          <label>Number of occupants age 65 or older</label>
          <div class="editable" data-model="Occupant" data-field="age_65"><?php echo !empty( $this->data['Occupant']['age_65'] ) ? $this->data['Occupant']['age_65'] : 0 ?></div>
        </li>
      </ul>
      <?php echo $this->Form->end() ?>
      <?php /** ?>
      <?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => __( 'Number of Occupants Age 0-5', true ), 'placeholder' => 'Example: 2', 'size' => '3' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => __( 'Number of Occupants Age 6-13', true ), 'placeholder' => 'Example: 1', 'size' => '3' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => __( 'Number of Occupants Age 14-64', true ), 'placeholder' => 'Example: 1', 'size' => '3' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => __( 'Number of Occupants Age 65 or Older', true ), 'placeholder' => 'Example: 2', 'size' => '3' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.daytime_occupancy', array( 'label' => __( 'Are occupants at home during the day?', true ) ) ) ?>
      
      <?php echo $this->Form->input( 'Building.setpoint_heating', array( 'label' => __( 'Thermostat setting (heating)', true ), 'placeholder' => 'Example: 68' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.heating_override', array( 'label' => __( 'Is the heat setting adjusted frequently?', true ) ) ) ?>
      <?php echo $this->Form->input( 'Building.setpoint_cooling', array( 'label' => __( 'Thermostat setting (cooling)', true ), 'placeholder' => 'Example: 75' ) ) ?>
      <?php echo $this->Form->input( 'Occupant.cooling_override', array( 'label' => __( 'Is the cooling setting adjusted frequently?', true ) ) ) ?>
  
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
    <?php */ ?>
    </div> <!-- #demographics -->
  </div>
</div>
