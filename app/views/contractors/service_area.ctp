<h1><?php __( 'Your Service Area' ) ?></h1>

<p><?php __( 'Let us know where you work so we can deliver leads in your area.' ) ?></p>

<p><?php __( 'When you select a state, we\'ll ask you to select the counties you operate within. To include additional states, simply select another from the dropdown list and a new column will be displayed.' ) ?></p>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <?php echo $this->Form->select( 'service_area_state', $states, null, array( 'empty' => 'Select a state...' ) ) ?>
  
  <ol id="county_list">
    <?php if( !empty( $serviced_state_counties ) ): ?>
      <?php foreach( $serviced_state_counties as $state => $counties ): ?>
        <li id="<?php echo strtolower( $state ) ?>">
          <h2><?php echo $state ?> <span>[<?php echo $this->Html->link( 'remove', '#', array( 'class' => 'remove column' ) ) ?>]</span></h2>
          <ol>
            <?php foreach( $counties as $county ): ?>
              <?php $input_id = 'ContractorCounty' + $county['County']['id'] ?>
              <li>
                <input type="checkbox" name="data[County][]" id="<?php echo $input_id ?>" value="<?php echo $county['County']['id'] ?>"<?php echo in_array( $county['County']['id'], $serviced_counties ) ? ' checked="checked"' : false ?> />
                <label for="<?php echo $input_id ?>"><?php echo $county['County']['county'] ?></label>
              </li>
            <?php endforeach; ?>
          </ol>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ol>
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
<?php echo $this->Html->link( __( 'Back', true ), $previous_url, array( 'class' => 'button' ) ) ?>
