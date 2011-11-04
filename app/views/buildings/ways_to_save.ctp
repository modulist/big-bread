<?php $this->set( 'title_for_layout', __( 'Ways to Save', true )) ?>

<h1 class="printable"><?php __( 'Visit SaveBigBread.com for the latest in personalized discounts and information' ) ?></h1>
<h2><?php printf( __( 'Rebates for %s', true ), $rebates_for ) ?></h2>

<div class="location-switch-wrapper clearfix">
  <?php echo $this->element( '../buildings/_location_switcher', array( 'locations' => $other_locations ) ) ?>
</div>
<?php echo $this->element( '../technology_incentives/_list', array( 'rebates' => $rebates, 'watch_list' => $watched_technologies, 'location_id' => $location_id, 'display_grouped' => true, 'show_unwatched' => true ) ) ?>
