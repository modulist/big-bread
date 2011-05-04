<?php # TODO: This is pretty ugly. Be nice to clean it up. ?>
<?php # Edits aren't saved via saveAll() and shouldn't be indexed ?>
<?php if( $this->action != 'edit' ): ?>
  <?php echo $this->Form->input( 'Product.0.technology_id', array( 'label' => 'Equipment Type', 'div' => 'input select equipment-type', 'required' => true, 'empty' => true ) ) ?>
  <?php echo $this->Form->input( 'Product.0.make' ) # TODO: Make this an autocomplete field ?>
  <?php echo $this->Form->input( 'Product.0.model' ) # TODO: Make this an autocomplete field ?>
  <?php echo $this->Form->input( 'Product.0.energy_source_id', array( 'empty' => 'Select equipment type', 'options' => array(), 'div' => 'input select energy-source', 'disabled' => 'disabled' ) ) ?>
  <?php echo $this->Form->input( 'BuildingProduct.0.serial_number', array( 'after' => '<p>The optional serial number will help us identify when the equipment was manufactured and the applicable warranty periods for that equipment.</p>' ) ) ?>
  <?php echo $this->Form->input( 'BuildingProduct.0.notes' ) ?>
<?php else: ?>
  <?php if( !isset( $product ) || empty( $product ) ): ?>
    <?php
      # Display inputs to create a new piece of equipment. This happens
      # one at a time, so note the lack of an index. This ensures that
      # the add inputs are unique from any edit inputs.
    ?>
    <?php echo $this->Form->input( 'Product.technology_id', array( 'label' => 'Equipment Type', 'div' => 'input select equipment-type', 'required' => true, 'empty' => true ) ) ?>
    <?php echo $this->Form->input( 'Product.make' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Product.model' ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Product.energy_source_id', array( 'empty' => 'Select equipment type', 'options' => array(), 'div' => 'input select energy-source', 'disabled' => 'disabled' ) ) ?>
    <?php echo $this->Form->input( 'BuildingProduct.serial_number', array( 'after' => '<p>The optional serial number will help us identify when the equipment was manufactured and the applicable warranty periods for that equipment.</p>' ) ) ?>
    <?php echo $this->Form->input( 'BuildingProduct.notes' ) ?>
  <?php else: ?>
    <?php # Here we're editing an existing piece of equipment ?>
    <?php $energy_source_options = Set::combine( $product['Product']['Technology']['EnergySource'], '{n}.incentive_tech_energy_type_id', '{n}.name' ) ?>
    
    <?php echo $this->Form->input( 'Product.' . $index . '.technology_id', array( 'type' => 'hidden', 'value' => $product['Product']['Technology']['id'] ) ) ?>
    <?php echo $this->Form->input( 'Product.' . $index . '.technology_name', array( 'label' => 'Equipment Type', 'div' => 'input text', 'disabled' => 'disabled', 'default' => Inflector::singularize( $product['Product']['Technology']['name'] ) ) ) ?>
    <?php echo $this->Form->input( 'Product.' . $index . '.make', array( 'default' => $product['Product']['make'] ) ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Product.' . $index . '.model', array( 'default' => $product['Product']['model'] ) ) # TODO: Make this an autocomplete field ?>
    <?php echo $this->Form->input( 'Product.' . $index . '.energy_source_id', array( 'div' => 'input select', 'options' => $energy_source_options, 'selected' => $product['Product']['energy_source_id'] ) ) ?>
    <?php echo $this->Form->input( 'BuildingProduct.' . $index . '.serial_number', array( 'default' => $product['serial_number'], 'after' => '<p>The optional serial number will help us identify when the equipment was manufactured and the applicable warranty periods for that equipment.</p>' ) ) ?>
    <?php echo $this->Form->input( 'BuildingProduct.' . $index . '.notes', array( 'default' => $product['notes'] ) ) ?>
  <?php endif; ?>
<?php endif; ?>
