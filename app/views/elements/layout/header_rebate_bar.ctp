<div id="bodyheader"> 
  <div id="bodyheaderhead">
    <?php echo isset( $incentive_count ) && !empty( $incentive_count ) ? $incentive_count : 0 ?>
  </div>
  
  <ul>
    <?php foreach( $technology_groups as $id => $group ): ?>
      <?php
        $group_incentive_count = isset( $incentives[$group] ) ? count( $incentives[$group] ) : 0;
        $group_incentive_total = 0;
        
        # TODO: Get Set::extract() to work here
        # The looping below is being done because I can't get Set::extract()
        # to work in either config that I think should work:
        # Set::extract( '/' . $group . '/IncentiveAmountType[incentive_amount_type_id=USD]/../TechnologyIncentive/amount', $incentives  )
        # Set::extract( '/' . $group . '/{n}/IncentiveAmountType[incentive_amount_type_id=USD]/../TechnologyIncentive/amount', $incentives  )
        if( isset( $incentives[$group] ) ) {
          foreach( $incentives[$group] as $incentive ) {
            if( $incentive['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ) {
              $group_incentive_total += $incentive['TechnologyIncentive']['amount'];
            }
          } 
        }
      ?>
      <li>
        <div class="savings"><?php echo $this->Number->currency( $group_incentive_total, 'USD' ) ?></div>
        <?php if( $group_incentive_count > 0 ): ?>
          <?php echo $this->Html->link(
            sprintf( '%s', '<span id="eq_' . Inflector::slug( $id, '' ) . ( $group_incentive_count === 0 ? '_off' : '' ) . '" class="eq">' . $group_incentive_count . '</span>' ),
            array( 'action' => 'incentives', $building['Building']['id'], strtolower( Inflector::slug( $group ) ) ),
            array( 'escape' => false )
          ) ?>
        <?php else: ?>
          <span id="eq_<?php echo Inflector::slug( $id, '' ) ?><?php echo $group_incentive_count === 0 ? '_off' : '' ?>" class="eq"><?php echo $group_incentive_count ?></span>
        <?php endif; ?>
        
        
        <a href="#<?php echo strtolower( Inflector::slug( $group ) ) ?>"></a>
        <p><?php echo $group ?></p>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="clear"></div>
