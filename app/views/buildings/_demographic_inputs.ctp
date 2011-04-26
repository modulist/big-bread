<?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => __( 'Number of Occupants Age 0-5', true ), 'placeholder' => 'Example: 2', 'size' => '3' ) ) ?>
<?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => __( 'Number of Occupants Age 6-13', true ), 'placeholder' => 'Example: 1', 'size' => '3' ) ) ?>
<?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => __( 'Number of Occupants Age 14-64', true ), 'placeholder' => 'Example: 1', 'size' => '3' ) ) ?>
<?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => __( 'Number of Occupants Age 65 or Older', true ), 'placeholder' => 'Example: 2', 'size' => '3' ) ) ?>
<?php echo $this->Form->input( 'Occupant.daytime_occupancy', array( 'label' => __( 'Are occupants at home during the day?', true ) ) ) ?>

<?php echo $this->Form->input( 'Building.setpoint_heating', array( 'label' => __( 'Thermostat setting (heating)', true ), 'placeholder' => 'Example: 68' ) ) ?>
<?php echo $this->Form->input( 'Occupant.heating_override', array( 'label' => __( 'Is the heat setting adjusted frequently?', true ) ) ) ?>
<?php echo $this->Form->input( 'Building.setpoint_cooling', array( 'label' => __( 'Thermostat setting (cooling)', true ), 'placeholder' => 'Example: 75' ) ) ?>
<?php echo $this->Form->input( 'Occupant.cooling_override', array( 'label' => __( 'Is the cooling setting adjusted frequently?', true ) ) ) ?>
