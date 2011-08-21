<!-- vertical nav -->
<div id="vertical-nav">
  <ul class="left-menu">
    <?php //foreach( Questionnaire::$navigation as $id => $label ): ?>
      <?php
      # Don't display the general tab once a building record exists
      /*if( $id == 'general' && $building_id != 'new' ) {
        continue;
      }
      
      $class = array();
      if( $id == $anchor ) {
        array_push( $class, 'active' );
      }
      if( $id != 'general' && $building_id == 'new' ) {
        array_push( $class, 'disabled' );
      }
      ?>
      
      <li><?php echo $this->Html->link( $label, array( 'action' => 'questionnaire', $building_id, $id ), array( 'class' => join( ' ', $class ) ) ) ?></li>*/
    <?php //endforeach; ?>
  </ul>
</div><!-- #questionnaire -->
