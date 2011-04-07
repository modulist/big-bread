<div id="questionnaire">
  <h2>Questionnaire</h2>
  <ul>
    <li><?php echo $this->Html->link( __( 'General Information', true ), '#', array( 'class' => 'active' ) ) ?></li>
    <li><?php echo $this->Html->link( __( 'Demographics & Behavior', true ), '#' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Equipment Listing', true ), '#' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Building Characteristics', true ), '#' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Insulation, Windows, Doors', true ), '#' ) ?></li>
  </ul>
</div><!-- #questionnaire -->

<div id="getstart">
  <h2><?php __( 'Let\'s Get Started' ) ?></h2>
  <?php echo $this->Html->image( 'DownloadQ.png' ) ?>
</div>
