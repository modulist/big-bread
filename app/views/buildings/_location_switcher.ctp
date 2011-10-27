<?php if( isset( $locations ) && is_array( $locations ) && count( $locations ) ): ?>
  <?php echo $this->Html->link( __( 'Switch locations:', true ), '#', array( 'class' => 'location-switcher', 'data-current' => h( $location['Building']['id'] ) ) ) ?>
  
  <ul class="other-location-list">
    <?php foreach( $other_locations as $i => $other_location ): ?>
      <?php $classes = array( $i % 2 == 0 ? 'odd' : 'even' ) # Adjusted for 0-based array ?>
      <?php array_push( $classes, $i == 0 ? 'first' : false, $i + 1 == count( $other_locations ) ? 'last' : false ) ?>
      <li class="leaf <?php echo join( ' ', array_filter( $classes ) ) ?>">
        <div class="other-location-name"><?php echo $this->Html->link( !empty( $other_location['Building']['name'] ) ? h( $other_location['Building']['name'] ) : h( $other_location['Address']['address_1'] ), array( 'controller' => strtolower( $this->name ), 'action' => $this->action, $other_location['Building']['id'] ) ) ?></div>
        <?php if( !empty( $other_location['Building']['name'] ) ): ?>
          <div class="other-location-address"><?php echo h( $other_location['Address']['address_1'] ) ?></div>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>