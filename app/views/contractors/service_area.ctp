<h1><?php __( 'Your Service Area' ) ?></h1>

<p><?php __( 'Let us know where you work so we can deliver leads in your area.' ) ?></p>

<p><?php __( 'When you select a state, we\'ll ask you to select the counties you operate within.' ) ?>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <?php echo $this->Form->select( 'service_area_state', $states, null, array( 'empty' => 'Select a state...' ) ) ?>
  
  <ol id="county_list">
    <!-- populated via javascript. @see /js/views/contractors/service_area.js -->
  </ol>
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
