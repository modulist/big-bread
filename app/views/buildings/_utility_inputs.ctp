<?php $show_account_numbers = isset( $show_account_numbers ) ? $show_account_numbers : false ?>

<?php echo $this->Form->input( 'ElectricityProvider.name', array( 'label' => __( 'Electricity Provider', true ) ) ) ?>
<?php echo $this->Form->input( 'ElectricityProvider.id' ) ?>

<?php if( $show_account_numbers ): ?>
  <?php echo $this->Form->input( 'Building.electricity_provider_account', array( 'label' => 'Account Number (Electricity)' ) ) ?>
<?php endif; ?>

<?php echo $this->Form->input( 'GasProvider.name', array( 'label' => __( 'Gas Provider', true ) ) ) ?>
<?php echo $this->Form->input( 'GasProvider.id' ) ?>

<?php if( $show_account_numbers ): ?>
  <?php echo $this->Form->input( 'Building.gas_provider_account', array( 'label' => 'Account Number (Gas)' ) ) ?>
<?php endif; ?>

<?php echo $this->Form->input( 'WaterProvider.name', array( 'label' => __( 'Water Provider', true ) ) ) ?>
<?php echo $this->Form->input( 'WaterProvider.id' ) ?>

<?php if( $show_account_numbers ): ?>
  <?php echo $this->Form->input( 'Building.water_provider_account', array( 'label' => 'Account Number (Water)' ) ) ?>
<?php endif; ?>