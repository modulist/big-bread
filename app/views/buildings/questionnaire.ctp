<?php $this->set( 'title_for_layout', __( 'My House', true ) ) ?>

<?php echo $this->Html->css( 'jqueryui/themes/aristo/jquery-ui-1.8.7.custom.css', null, array( 'inline' => false ) ) ?>

<?php if( !empty( $this->data['Building']['id'] ) ): ?>  
  <?php echo $this->element( 'building_info', array( 'building' => $this->data, 'editable' => true ) ) ?>
<?php endif; ?>

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'questionnaire', $building_id, $anchor ) ) ) ?>
<?php echo $this->Form->hidden( 'Wizard.continue', array( 'value' => 1 ) ) ?>
<?php echo $this->Form->input( 'Building.id' ) ?>
<?php # Really just a placeholder so that a Questionnaire record gets saved by saveAll() ?>
<?php echo $this->Form->input( 'Questionnaire.deleted', array( 'type' => 'hidden', 'value' => 0 ) ) ?>

<div id="general_Info">
  <div id="info">
    <?php if( $this->Session->read( 'Auth.User.show_questionnaire_instructions' ) ): ?>
      <div class="flash info long">
        <p class="first">
        Welcome to BigBread.net.  All we need to get started is to have you provide the client's (either the homeowner or buyer) name, address and zip code.
        If the client is a home buyer, please enter the address information for the home you're contemplating buying so we can provide the applicable rebates for that house.
        We'd love your comments, please use the feedback button so we can improve your experience.  Thank you for visiting us.
        </p>
        
        <p>If you provide more information found on our questionnaire (<?php echo $this->Html->link( 'download the attached form', array( 'action' => 'download_questionnaire' ), array() ) ?> to take notes as you go through the house) and add that information to your online form, we can find even more savings for you.</p>
        
        <p class="last"><a href="#" class="dismiss" data-notice="questionnaire_instructions">Don't show this message again.</a></p>
      </div>
    <?php endif; ?>
    
    <div class="form">
      <?php if( empty( $this->data['Building']['id'] ) ): ?>
        <div id="general" class="section<?php echo $anchor == 'general' ? ' active' : '' ?>">
          <h1 id="infohead"><?php __( 'General Information' ) ?></h1>
          <?php echo $this->Form->input( 'Client.id' ) ?>
          <?php echo $this->Form->input( 'Client.first_name', array( 'label' => __( 'Client First Name', true ) ) ) ?>
          <?php echo $this->Form->input( 'Client.last_name', array( 'label' => __( 'Client Last Name', true ) ) ) ?>
          <?php echo $this->Form->input( 'Client.email', array( 'label' => __( 'Client Email', true ) ) ) ?>
          <?php echo $this->Form->input( 'Client.phone_number', array( 'label' => __( 'Client Phone Number', true ) ) ) ?>
          <?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'radio', 'legend' => false, 'default' => User::TYPE_HOMEOWNER ) ) ?>
          
          <?php echo $this->Form->input( 'Address.id' ) ?>
          <?php echo $this->Form->input( 'Address.address_1' ) ?>
          <?php echo $this->Form->input( 'Address.address_2' ) ?>
          <?php echo $this->Form->input( 'Address.zip_code' ) ?>
          
          <?php echo $this->element( '../buildings/_realtor_inputs' ) ?>
          
          <?php echo $this->element( '../buildings/_inspector_inputs' ) ?>
        </div> <!-- #general -->
      <?php else: ?>
        <div class="sliding-panel aside" id="realtor">
          <h1><?php __( 'Change Realtor' ) ?></h1>
          <?php echo $this->element( '../buildings/_realtor_inputs' ) ?>
          
          <div class="buttons">
            <div class="button">
              <input type="submit" value="Save" />
            </div>
            <div class="button">
              <input type="reset" value="Cancel" />
            </div>
          </div>
        </div>
        <div class="sliding-panel aside" id="inspector">
          <h1><?php __( 'Change Inspector' ) ?></h1>
          <?php echo $this->element( '../buildings/_inspector_inputs' ) ?>
          
          <div class="buttons">
            <div class="button">
              <input type="submit" value="Save" />
            </div>
            <div class="button">
              <input type="reset" value="Cancel" />
            </div>
          </div>
        </div>
      <?php endif; ?>
  
      <div id="demographics" class="section<?php echo $anchor == 'demographics' ? ' active' : '' ?>">
        <h1><?php __( 'Demographics' ) ?></h1>
        <?php echo $this->element( '../buildings/_demographic_inputs' ) ?>
      </div> <!-- #demographics -->
        
      <div id="equipment" class="section<?php echo $anchor == 'equipment' ? ' active' : '' ?>">
        <!--
        <div id="utility-providers">
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
         -->
        <h1><?php __( 'Equipment Listing' ) ?></h1>
        
        <p>The equipment detail allows us to research product safety, recall, and warranty information on what you already own.</p>
        
        <table>
        <thead>
          <tr>
            <th><?php __( 'Technology' ) ?></th>
            <th><?php __( 'Make' ) ?></th>
            <th><?php __( 'Model' ) ?></th>
            <th><?php __( 'Serial' ) ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if( !empty( $this->data['BuildingProduct'] ) ): ?>
            <?php foreach( $this->data['BuildingProduct'] as $building_product ): ?>
              <tr>
                <td><?php echo h( $building_product['Product']['Technology']['name'] ) ?></td>
                <td><?php echo h( $building_product['Product']['make'] ) ?></td>
                <td><?php echo h( $building_product['Product']['model'] ) ?></td>
                <td><?php echo h( $building_product['serial_number'] ) ?></td>
                <td>
                  <?php echo $this->Html->link( __( 'edit', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Product', 'data-id' => $building_product['id'] ) ) ?>
                  | <?php echo $this->Html->link( __( 'retire', true ), array( 'controller' => 'BuildingProducts', 'action' => 'retire', $building_product['id'] ), array( 'class' => 'action delete retire' ) ) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <td colspan="4">No equipment has been added. <?php echo $this->Html->link( __( 'Add something now', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Product' ) ) ?>.</td>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4"><?php echo $this->Html->link( __( 'Add a new piece of equipment', true ), '#', array( 'class' => 'button toggle-form', 'data-model' => 'Product' ) ) ?></td>
          </tr>
        </tfoot>
        </table>
          
        <?php # Sliding panel for each existing piece of equipment ?>
        <?php if( !empty( $this->data['BuildingProduct'] ) ): ?>
          <?php foreach( $this->data['BuildingProduct'] as $i => $building_product ): ?>
            <div class="sliding-panel" id="product-<?php echo $building_product['id'] ?>">
              <?php $energy_source_options = Set::combine( $building_product['Product']['Technology']['EnergySource'], '{n}.incentive_tech_energy_type_id', '{n}.name' ) ?>
              
              <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.id' ) ?>
              <?php echo $this->Form->input( 'Product.' . $i . '.technology_id', array( 'type' => 'hidden', 'value' => $building_product['Product']['Technology']['id'] ) ) ?>
              <?php echo $this->Form->input( 'Product.' . $i . '.technology_name', array( 'label' => 'Equipment Type', 'div' => 'input text', 'disabled' => 'disabled', 'default' => Inflector::singularize( $building_product['Product']['Technology']['name'] ) ) ) ?>
              <?php echo $this->Form->input( 'Product.' . $i . '.make', array( 'default' => $building_product['Product']['make'] ) ) # TODO: Make this an autocomplete field ?>
              <?php echo $this->Form->input( 'Product.' . $i . '.model', array( 'default' => $building_product['Product']['model'] ) ) # TODO: Make this an autocomplete field ?>
              <?php echo $this->Form->input( 'Product.' . $i . '.energy_source_id', array( 'div' => 'input select', 'options' => $energy_source_options, 'selected' => $building_product['Product']['energy_source_id'] ) ) ?>
              <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.serial_number', array( 'default' => $building_product['serial_number'] ) ) ?>
              <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.notes', array( 'default' => $building_product['notes'] ) ) ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
 
        <?php # Sliding panel for a new piece of equipment ?>
        <?php $i = !empty( $this->data['BuildingProduct'] ) ? count( $this->data['BuildingProduct'] ) : 0  ?>
        <div class="sliding-panel" id="product">
          <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.id' ) ?>
          <?php echo $this->Form->input( 'Product.' . $i . '.technology_id', array( 'label' => 'Equipment Type', 'div' => 'input select equipment-type required', 'empty' => true ) ) ?>
          <?php echo $this->Form->input( 'Product.' . $i . '.make' ) # TODO: Make this an autocomplete field ?>
          <?php echo $this->Form->input( 'Product.' . $i . '.model' ) # TODO: Make this an autocomplete field ?>
          <?php echo $this->Form->input( 'Product.' . $i . '.energy_source_id', array( 'empty' => 'Select equipment type', 'options' => array(), 'div' => 'input select energy-source', 'disabled' => 'disabled' ) ) ?>
          <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.serial_number' ) ?>
          <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.notes' ) ?>
        </div>
         
      </div> <!-- #equipment -->
    
      <div id="characteristics" class="section<?php echo $anchor == 'characteristics' ? ' active' : '' ?>">
        <h2><?php __( 'Building Characteristics' ) ?></h2>
        <?php echo $this->element( '../buildings/_building_characteristics_inputs' ) ?>
      </div> <!-- #characteristics -->
    
      <div id="envelope" class="section<?php echo $anchor == 'envelope' ? ' active' : '' ?>">
        <h2><?php __( 'Insulation, Windows &amp; Doors' ) ?></h2>
        
        <h3><?php __( 'Windows' ) ?></h3>
        <?php echo $this->element( '../buildings/_window_inputs' ) ?>
         
        <h3><?php __( 'Air Tightness' ) ?></h3>
        <?php echo $this->element( '../buildings/_air_tightness_inputs' ) ?>
        
        <h3><?php __( 'Roof' ) ?></h3>
        <?php echo $this->element( '../buildings/_roof_inputs' ) ?>
      </div> <!-- #envelope -->
  
      <div class="buttons">
        <div class="button">
          <input type="submit" value="Continue" id="btn-continue" />
        </div>
        
        <div class="button<?php echo $anchor !== 'equipment' ? ' disabled' : '' ?>">
          <input type="submit" value="Save &amp; Return" id="btn-return" />
        </div>
    </div> <!-- .form -->
  </div> <!-- #info -->
</div> <!-- #general_Info -->

<div id="questionnaire_act">
  <div class="clear"></div>
</div>
<?php echo $this->Form->end() ?>
