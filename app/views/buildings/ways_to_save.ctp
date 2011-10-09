<?php $this->set( 'title_for_layout', __( 'Ways to Save', true )) ?>

<!-- Used by the address list in the sidebar -->
<?php echo $this->Html->script( 'jquery/jquery.cycle.all.min.js', array( 'inline' => false ) ) ?>

<h1 class="printable"><?php __( 'Visit SaveBigBread.com for the latest in personalized discounts and information' ) ?></h1>

<!-- start new html code for rebates table -->
<div id="my-rebates" class="grid_9">
<h2><?php printf( __( 'Rebates for %s', true ), $rebates_for ) ?></h2>
  <table class="rebates-watch-list">
    <tbody>
      <?php $i = 0; ?>
      <?php foreach( $rebates as $tech_name => $tech_rebates ): ?>
        <?php $tech_id = array_shift( Set::extract( '/Technology/id[:first]', $tech_rebates ) ) ?>
        <tr class="rebate-category-row<?php echo $i++ == 0 ? ' first' : false ?>">
          <td class="rebate-category">
            <table class="rebate-header">
              <tr>
                <td class="rebate-description">
                  <?php echo $this->Html->link( '<span class="rebate-category-title">' . $tech_name . '</span> (' . count( $tech_rebates ) . ')', '#', array( 'class' => 'toggle collapsed', 'escape' => false ) ) ?>
                  
                  <?php $watched = in_array( $tech_id, $watched_technologies ) ? ' active' : false ?>
                  <?php echo $this->Html->link( '', '#', array( 'class' => 'star' . $watched, 'title' => 'Click to add/remove this interest', 'data-user-id' => $this->Session->read( 'Auth.User.id' ), 'data-technology-id' => $tech_id, 'data-location-id' => $location_id ) ) ?>
                </td>
                <td class="rebate-amount"><?php echo $this->Number->format( array_sum( Set::extract( '/TechnologyIncentive/amount', $tech_rebates ) ), array( 'places' => 0, 'before' => '$' ) ) ?></td>
                <td class="rebate-total"><?php __( 'total' ) ?></td>
              </tr>
            </table>
        
            <?php foreach( $tech_rebates as $rebate ): ?>
              <table class="rebate-content">
                <tr class="first odd">
                  <td class="rebate-description">
                    <?php echo $this->Html->link( h( $rebate['Incentive']['name'] ), '#' ) ?>
                    <?php echo $this->Html->link( __( 'details &rsaquo;', true ), array( 'controller' => 'technology_incentives', 'action' => 'details', $rebate['TechnologyIncentive']['id'] ), array( 'class' => 'details', 'escape' => false ) ) ?>
                  </td>
                  <td class="rebate-dates"><?php empty( $rebate['Incentive']['expiration_date'] ) ? __( 'while funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ?></td>
                  <td class="rebate-amount"><?php echo $this->Number->format( $rebate['TechnologyIncentive']['amount'], array( 'places' => 0, 'before' => '$' ) ) ?></td>
                  <td class="rebate-action">
                    <?php echo $this->Html->link( __( 'GET A QUOTE &rsaquo;', true ), array( 'controller' => 'technology_incentives', 'action' => 'quote', $rebate['TechnologyIncentive']['id'] ), array( 'class' => 'quote-button', 'escape' => false ) ) ?>
                  </td>
                </tr>
              </table> 
            <?php endforeach; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div> <!-- #my-rebates -->
