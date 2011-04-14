<div id="bodyheader"> 
  <div id="bodyheaderhead">
    <?php echo isset( $incentive_count ) && !empty( $incentive_count ) ? $incentive_count : 0 ?>
  </div>
  <ul>
    <?php $i = 0 ?>
    <?php foreach( $technology_groups as $id => $group ): ?>
      <?php $i++; ?>
      <?php $group_incentive_count = isset( $incentives[$group] ) ? count( $incentives[$group] ) : 0 ?>
      <?php $dollars_available = array_sum( Set::extract( '/' . $group . '/TechnologyIncentive[incentive_amount_type_id=USD]/amount', $incentives  ) ) ?>
      <li>
        <div class="savings"><?php echo $this->Number->currency( $dollars_available, 'USD' ) ?></div>
        <a href="#"><span id="eq_<?php echo Inflector::slug( $id, '' ) ?><?php echo $group_incentive_count === 0 ? '_off' : '' ?>" class="eq"><?php echo $group_incentive_count ?></spanb></a>
        <p><?php echo $group ?></p>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="clear"></div>
