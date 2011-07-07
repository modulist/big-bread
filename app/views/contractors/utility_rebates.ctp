<h1><?php __( 'Utility Rebate Participation' ) ?></h1>

<p><?php __( 'Finally, tell us which, if any, utility-offered rebates you\'ve been certified to participate in.' ) ?></p>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <?php foreach( $utilities as $i => $utility_chunk ): ?>
    <div class="input select horizontal">
      <?php foreach( $utility_chunk as $utility ): ?>
        <div class="checkbox">
          <input type="checkbox" name="data[Utility][]" id="UtilityIncentiveParticipant<?php echo $utility['Utility']['id'] ?>" value="<?php echo $utility['Utility']['id'] ?>"<?php echo isset( $utility_relationships[$utility['Utility']['id']] ) ? ' checked="checked"' : false ?> />
          <label for="UtilityIncentiveParticipant<?php echo $utility['Utility']['id'] ?>"><?php echo $utility['Utility']['name'] ?></label>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  <div class="clear"></div>

  <div class="buttons">
    <div class="button">
      <input type="submit" value="<?php __( 'Next' ) ?>" />
    </div>
    <div class="button">
      <input type="reset" value="<?php __( 'Back' ) ?>" class="previous" data-previous="<?php echo Router::url( $previous_url ) ?>" />
    </div>
  </div>
<?php echo $this->Form->end() ?>
