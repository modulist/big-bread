<div id="questionnaire">
  <h2>Questionnaire</h2>
  <ul>
    <?php if( $this->action == 'questionnaire' ): # handled differently in edit ?>
      <li><?php echo $this->Html->link( __( 'General Information', true ), '#info', array( 'class' => 'active' ) ) ?></li>
    <?php endif; ?>
    <li><?php echo $this->Html->link( __( 'Demographics & Behavior', true ), '#demographics' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Equipment Listing', true ), '#equipment' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Building Characteristics', true ), '#characteristics' ) ?></li>
    <li><?php echo $this->Html->link( __( 'Insulation, Windows, Doors', true ), '#envelope' ) ?></li>
  </ul>
</div><!-- #questionnaire -->
