<div id="my-utilities" class="grid_9">
  <div class="utilities-wrapper clearfix">
    <div class="utilities-icon"></div>
      <div class="grid_4">
        <?php echo $this->Form->input( 'ElectricityProvider.name', array( 'label' => __( 'Electricity Provider', true ) ) ) ?>
        <?php echo $this->Form->input( 'ElectricityProvider.id' ) ?>
        
        <?php echo $this->Form->input( 'GasProvider.name', array( 'label' => __( 'Gas Provider', true ) ) ) ?>
        <?php echo $this->Form->input( 'GasProvider.id' ) ?>
        
        <?php echo $this->Form->input( 'WaterProvider.name', array( 'label' => __( 'Water Provider', true ) ) ) ?>
        <?php echo $this->Form->input( 'WaterProvider.id' ) ?>
      </div><!-- /grid-4 -->
    </div><!-- /utilities-wrapper -->
</div><!-- /my-utilities -->