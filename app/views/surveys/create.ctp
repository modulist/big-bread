<h1>Home Survey</h1>

<?php echo $this->Form->create( 'Survey' ) ?>
  <?php echo $this->Form->input( 'Realtor.first_name', array( 'label' => 'Realtor First Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.last_name', array( 'label' => 'Realtor Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Realtor.email', array( 'label' => 'Realtor Email' ) ) ?>
  
  <?php echo $this->Form->input( 'Inspector.first_name', array( 'label' => 'Inspector First Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.last_name', array( 'label' => 'Inspector Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Inspector.email', array( 'label' => 'Inspector Email' ) ) ?>
  
  <?php echo $this->Form->input( 'Homeowner.first_name', array( 'label' => 'Homeowner First Name' ) ) ?>
  <?php echo $this->Form->input( 'Homeowner.last_name', array( 'label' => 'Homeowner Last Name' ) ) ?>
  <?php echo $this->Form->input( 'Homeowner.email', array( 'label' => 'Homeowner Email' ) ) ?>
  
  <?php echo $this->Form->input( 'Occupant.age_0_5', array( 'label' => 'Ages 0-5' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_6_13', array( 'label' => 'Ages 6-13' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_14_64', array( 'label' => 'Ages 14-64' ) ) ?>
  <?php echo $this->Form->input( 'Occupant.age_65', array( 'label' => 'Ages 65+' ) ) ?>
  
  
<?php echo $this->Form->end( 'Save' ) ?>
