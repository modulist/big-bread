<?php $this->set( 'title_for_layout', __( 'Incentives', true )) ?>

<h1>Available Incentives for <?php echo $zip_code ?></h1>

<?php if( !empty( $incentives ) ): ?>
  <ol>
    <?php foreach( $incentives as $incentive ): ?>
      <li><?php new PHPDump( $incentive['Incentive'] ); ?></li>
    <?php endforeach; ?>
  <ol>
<?php endif; ?>
