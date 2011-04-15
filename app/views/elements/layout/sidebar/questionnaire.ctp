<div id="questionnaire">
  <h2>Questionnaire</h2>
  <ul>
    <li><?php echo $this->Html->link( __( 'General Information', true ), '#info', array( 'class' => 'active' ) ) ?></li>
    <li><?php echo $this->Html->link( __( 'Demographics & Behavior', true ), '#demographics' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Equipment Listing', true ), '#equipment_list' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Building Characteristics', true ), '#building_characteristics' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Insulation, Windows, Doors', true ), '#building_envelope' ) ?></li>
  </ul>
</div><!-- #questionnaire -->

<?php echo $this->element( 'layout/sidebar/_get_started' ) ?>
