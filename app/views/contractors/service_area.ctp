<h1><?php __( 'Your Service Area' ) ?></h1>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <?php new PHPDump( $states, 'States' ); ?>
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
