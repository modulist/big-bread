<?php $this->set( 'title_for_layout', __( 'Ways to Save', true )) ?>

<h1 class="printable"><?php __( 'Visit SaveBigBread.com for the latest in personalized discounts and information' ) ?></h1>
<h2><?php printf( __( 'Rebates for %s', true ), $rebates_for ) ?></h2>

<?php echo $this->element( '../technology_incentives/_list', array( 'rebates' => $rebates, 'watch_list' => $watched_technologies, 'location_id' => $location_id ) ) ?>
