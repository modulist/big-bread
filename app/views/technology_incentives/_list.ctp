<?php $display_grouped = isset( $display_grouped ) ? $display_grouped : false ?>
<?php $show_unwatched  = isset( $show_unwatched ) ? $show_unwatched : false ?>

<div id="my-rebates" class="grid_9">
  <table class="rebates-watch-list">
    <tbody>
      <?php $i = 0; ?>
      <?php $group = null ?>
      <?php foreach( $rebates as $tech_name => $tech_rebates ): ?>
        <?php $tech_group  = $display_grouped ? array_shift( Set::extract( '/TechnologyGroup/title', $tech_rebates ) ) : false ?>
        <?php $tech_id     = array_shift( Set::extract( '/Technology/id[:first]', $tech_rebates ) ) ?>
        <?php $watched     = in_array( $tech_id, $watch_list ) ?>
        
        <?php if( $watched || $show_unwatched ): ?>
          <?php if( $i++ == 0 ): ?>
            <?php $class = ' first' ?>
          <?php elseif( $i == count( $rebates ) ): ?>
            <?php $class = ' last' ?>
          <?php else: ?>
            <?php $class = false ?>
          <?php endif; ?>
        <?php else: ?>
          <?php $class = ' hidden' ?>
        <?php endif; ?>
        
        <?php if( $tech_group != $group ): ?>
          <tr class="group-name"<?php echo !$watched && !$show_unwatched ? ' style="display: none;"' : false ?> data-technology-id="<?php echo h( $tech_id ) ?>">
            <td><?php echo $tech_group ?></td>
          </tr>
          
          <?php $group = $tech_group ?>
        <?php endif; ?>
        <tr class="rebate-category-row<?php echo $class ?>" data-technology-id="<?php echo h( $tech_id ) ?>">
          <td class="rebate-category">
            <table class="rebate-header">
              <tr>
                <td class="rebate-description">
                  <?php echo $this->Html->link( '<span class="rebate-category-title">' . h( $tech_name ) . '</span> (' . count( $tech_rebates ) . ')', '#', array( 'class' => 'toggle collapsed', 'escape' => false ) ) ?>
                  
                  <?php echo $this->Html->link( '', array( 'controller' => 'users', 'action' => !in_array( $tech_id, $watch_list ) ? 'watch' : 'unwatch', 'Technology', $tech_id, $location_id ), array( 'class' => sprintf( 'star %s', $watched ? 'active' : false ), 'title' => sprintf( __( 'Click to %s this interest', true ), $watched ? 'remove' : 'add' ), 'data-technology-id' => $tech_id ) ) ?>
                </td>
                <td class="rebate-amount">
                  <?php $amounts  = Set::extract( '/IncentiveAmountType[incentive_amount_type_id=USD]/../TechnologyIncentive/amount', $tech_rebates ) ?>
                  <?php $percents = Set::extract( '/IncentiveAmountType[incentive_amount_type_id=PERC]/../TechnologyIncentive/amount', $tech_rebates ) ?>
                  
                  <?php if( array_sum( $amounts ) > 0 ): ?>
                    <?php printf( '%s %s', $this->Number->format( array_sum( $amounts ), array( 'places' => 0, 'before' => '$' ) ), __( 'total', true ) ) ?>
                  <?php elseif( !empty( $percents ) ): ?>
                    <?php printf( '%s %s', __( 'Up to', true ), $this->Number->format( max( $percents ), array( 'places' => 0, 'before' => false, 'after' => '%' ) ) ) ?>
                  <?php else: ?>
                    <?php $max = max( Set::extract( '/IncentiveAmountType[incentive_amount_type_id!=/USD|PERC/]/../TechnologyIncentive/amount', $tech_rebates ) ) ?>
                    <?php printf( '%s %s', __( 'Up to', true ), $this->Number->format( $max, array( 'places' => 0, 'before' => false, 'after' => array_shift( Set::extract( '/TechnologyIncentive[amount=' . $max . ']/../IncentiveAmountType/name', $tech_rebates ) ) ) ) ) ?>
                  <?php endif; ?>
                </td>
              </tr>
            </table>
        
            <table class="rebate-content">
              <?php $j = 0 ?>
              <?php foreach( $tech_rebates as $rebate ): ?>
                <tr class="first <?php echo $j++ % 2 === 0 ? 'even' : 'odd' ?>">
                  <td class="rebate-description">
                    <?php echo h( $rebate['Incentive']['name'] ) ?>
                    <?php if( !empty( $rebate['TechnologyOption'] ) ): ?>
                      <div><?php printf( __( 'Equipment: %s', true ), join( ', ', Set::extract( '/TechnologyOption/name', $rebate ) ) ) ?></div>
                    <?php endif; ?>
                    <?php echo $this->Html->link( __( 'details &rsaquo;', true ), array( 'controller' => 'technology_incentives', 'action' => 'details', h( $rebate['TechnologyIncentive']['id'] ), h( $location_id ) ), array( 'class' => 'details', 'title' => sprintf( '%s > %s', $rebate['TechnologyGroup']['title'], $rebate['Technology']['title'] ), 'escape' => false ) ) ?>
                  </td>
                  <td class="rebate-dates"><?php echo empty( $rebate['Incentive']['expiration_date'] ) ? __( 'while funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ?></td>
                  <td class="rebate-amount"><?php echo $this->Number->format( $rebate['TechnologyIncentive']['amount'], array( 'places' => 0, 'before' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? h( $rebate['IncentiveAmountType']['name'] ) : false, 'after' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? h( $rebate['IncentiveAmountType']['name'] ) : false ) ) ?></td>
                  <td class="rebate-action">
                    <?php echo $this->Html->link( __( 'Get a Quote &rsaquo;', true ), array( 'controller' => 'proposals', 'action' => 'quote', h( $rebate['TechnologyIncentive']['id'] ), h( $location_id ) ), array( 'class' => 'quote-button', 'escape' => false ) ) ?>
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