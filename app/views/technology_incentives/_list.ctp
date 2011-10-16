<div id="my-rebates" class="grid_9">
  <table class="rebates-watch-list">
    <tbody>
      <?php $i = 0; ?>
      <?php foreach( $rebates as $tech_name => $tech_rebates ): ?>
        <?php $tech_id = array_shift( Set::extract( '/Technology/id[:first]', $tech_rebates ) ) ?>
        <?php if( $i++ == 0 ): ?>
          <?php $class = ' first' ?>
        <?php elseif( $i == count( $rebates ) ): ?>
          <?php $class = ' last' ?>
        <?php else: ?>
          <?php $class = false ?>
        <?php endif; ?>
        <tr class="rebate-category-row<?php echo $class ?>">
          <td class="rebate-category">
            <table class="rebate-header">
              <tr>
                <td class="rebate-description">
                  <?php echo $this->Html->link( '<span class="rebate-category-title">' . $tech_name . '</span> (' . count( $tech_rebates ) . ')', '#', array( 'class' => 'toggle collapsed', 'escape' => false ) ) ?>
                  
                  <?php $watched = in_array( $tech_id, $watch_list ) ? ' active' : false ?>
                  <?php echo $this->Html->link( '', '#', array( 'class' => 'star' . $watched, 'title' => 'Click to add/remove this interest', 'data-user-id' => $this->Session->read( 'Auth.User.id' ), 'data-technology-id' => $tech_id, 'data-location-id' => $location_id ) ) ?>
                </td>
                <td class="rebate-amount"><?php echo $this->Number->format( array_sum( Set::extract( '/IncentiveAmountType[incentive_amount_type_id=USD]/../TechnologyIncentive/amount', $tech_rebates ) ), array( 'places' => 0, 'before' => '$' ) ) ?></td>
                <td class="rebate-total"><?php __( 'total' ) ?></td>
              </tr>
            </table>
        
            <table class="rebate-content">
              <?php $j = 0 ?>
              <?php foreach( $tech_rebates as $rebate ): ?>
                <tr class="first <?php echo $j++ % 2 === 0 ? 'even' : 'odd' ?>">
                  <td class="rebate-description">
                    <?php echo h( $rebate['Incentive']['name'] ) ?>
                    <?php echo $this->Html->link( __( 'details &rsaquo;', true ), array( 'controller' => 'technology_incentives', 'action' => 'details', $rebate['TechnologyIncentive']['id'] ), array( 'class' => 'details', 'title' => 'Rebate details', 'escape' => false ) ) ?>
                  </td>
                  <td class="rebate-dates"><?php echo empty( $rebate['Incentive']['expiration_date'] ) ? __( 'while funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ?></td>
                  <td class="rebate-amount"><?php echo $this->Number->format( $rebate['TechnologyIncentive']['amount'], array( 'places' => 0, 'before' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? $rebate['IncentiveAmountType']['name'] : false, 'after' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? $rebate['IncentiveAmountType']['name'] : false ) ) ?></td>
                  <td class="rebate-action">
                    <?php echo $this->Html->link( __( 'GET A QUOTE &rsaquo;', true ), array( 'controller' => 'technology_incentives', 'action' => 'quote', $rebate['TechnologyIncentive']['id'], $location_id ), array( 'class' => 'quote-button', 'escape' => false ) ) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table> 
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div> <!-- #my-rebates -->