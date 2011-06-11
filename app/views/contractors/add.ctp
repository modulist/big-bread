<h1><?php __( 'Contact Information' ) ?></h1>

<?php echo $this->Form->create( 'Contractor', array( 'url' => array( 'add', $user_id ) ) ) ?>
  <?php echo $this->Form->input( 'Contractor.company_name' ) ?>
<?php echo $this->Form->end( 'Next' ) ?>
