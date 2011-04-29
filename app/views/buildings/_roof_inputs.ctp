<?php foreach( $roofSystems as $i => $roof_system ): ?>
  <?php if( !empty( $this->data['BuildingRoofSystem'] ) ): ?>
    <?php foreach( $this->data['BuildingRoofSystem'] as $building_roof ): ?>
      <?php $checked  = $building_roof['roof_system_id'] == $roof_system['RoofSystem']['id'] ? 'checked' : false; ?>
      <?php $coverage = $checked ? $building_roof['living_space_ratio'] : '' ?>
      <?php $id       = $checked ? $building_roof['id'] : false ?>
      
      <?php if( $checked ): ?>
        <?php break; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <?php $checked  = false ?>
    <?php $coverage = '' ?>
    <?php $id       = false ?>
  <?php endif; ?>
  
  <?php echo $this->Form->input( 'BuildingRoofSystem.' . $i . '.id', array( 'type' => 'hidden', 'value' => $id ) ) ?>
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
