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
  
      <div id="equipment">
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
  
      <div id="characteristics">
        <h2><?php __( 'Building Characteristics' ) ?></h2>
        <?php echo $this->element( '../buildings/_building_characteristics_inputs' ) ?>
      </div> <!-- #building_characteristics -->
  
      <div id="envelope">
        <h2><?php __( 'Insulation, Windows &amp; Doors' ) ?></h2>
        
        <h3><?php __( 'Windows' ) ?></h3>
        <?php echo $this->element( '../buildings/_window_inputs' ) ?>
         
        <h3><?php __( 'Air Tightness' ) ?></h3>
        <?php echo $this->element( '../buildings/_air_tightness_inputs' ) ?>
        
        <h3><?php __( 'Roof' ) ?></h3>
        <?php echo $this->element( '../buildings/_roof_inputs' ) ?>
        
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
