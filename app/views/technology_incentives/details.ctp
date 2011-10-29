<div class="modal popup">
	<div class="breadcrumb"><?php echo h( $rebate['Technology']['TechnologyGroup']['title'] ) ?> &gt; <?php echo h( $rebate['Technology']['title'] ) ?></div>
	<h2><?php echo h( $rebate['Incentive']['name'] ) ?></h2>
	
  <?php if( !empty( $rebate['Incentive']['AdditionalIncentiveNote'] ) ): ?>
      <?php $i = 0; ?>
      <?php foreach( $rebate['Incentive']['AdditionalIncentiveNote'] as $note ): ?>
        <?php $classes = array( $i++ % 2 === 0 ? 'odd' : 'even' ) ?>
        <?php if( $i === 1 ): ?>
          <?php array_push( $classes, 'first' ) ?>
        <?php endif; ?>
        <?php if( $i === count( $rebate['Incentive']['AdditionalIncentiveNote'] ) ): ?>
          <?php array_push( $classes, 'last' ) ?>
        <?php endif; ?>
        
        <p class="public-note <?php echo join( ' ', $classes ) ?>"><?php echo h( $note['note'] ) ?></p>
      <?php endforeach; ?>
  <?php endif; ?>
  
	<table class="savings-detail-grid">
		<thead class="first">
			<th class="valid first"><?php __( 'Valid until' ) ?></th>
			<th class="options"><?php __( 'Options' ) ?></th>
			<th class="source last"><?php __( 'Energy Source' ) ?></th>
		</thead>
		<tr>
			<td class="valid first"><?php echo empty( $rebate['Incentive']['expiration_date'] ) ? __( 'While funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ?></td>
			<td class="options">
        <?php if( !empty( $rebate['TechnologyOption'] ) ): ?>
          <ul>
            <?php foreach( $rebate['TechnologyOption'] as $option ): ?>
              <?php $explanation = !empty( $option['GlossaryTerm']['definition'] ) ? h( $option['GlossaryTerm']['definition'] ) : false ?>
              <li<?php echo !empty( $explanation ) ? ' class="tooltip" title="' . $explanation . '"' : false ?>><?php echo h( $option['name'] ) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <?php __( 'None' ) ?>
        <?php endif; ?>
      </td>
			<td class="source">
        <?php foreach( $rebate['EnergySource'] as $esource ): ?>
          <li><?php echo h( $esource['name'] ) ?></li>
        <?php endforeach; ?>
      </td>
		</tr>
    <?php if( !empty( $rebate['TechnologyTerm'] ) ): ?>
      <thead char="last">
        <th class="terms first"><?php __( 'Terms' ) ?></th>
        <th class="conditions last" colspan="2"><?php __( 'Conditions' ) ?></th>
      </thead>
      <?php foreach( $rebate['TechnologyTerm'] as $term ): ?>
        <?php $explanation = !empty( $term['GlossaryTerm']['definition'] ) ? h( $term['GlossaryTerm']['definition'] ) : false ?>
        <tr>
          <td class="terms first">
            <span<?php echo !empty( $explanation ) ? ' class="tooltip" title="' . $explanation . '"' : false ?>><?php echo h( $term['name'] ) ?></span>
          </td>
          <td class="conditions last" colspan="2">
            <?php if( !empty( $term['field1_name'] ) || !empty( $term['field2_name'] ) || !empty( $term['field3_name'] )  ): ?>
              <ul>
                <?php foreach( array( 'field1', 'field2', 'field3' ) as $i => $field ): ?>
                  <?php if( !empty( $term[$field . '_name'] ) && !empty( $term['IncentiveTechTerm'][$field . '_value'] ) ): ?>
                    <?php $display = $field != 'field3' # For field3, don't display the name value.
                      ? h( $term[$field . '_name'] ) . ' = ' . h( $term['IncentiveTechTerm'][$field . '_value'] )
                      : h( $term['IncentiveTechTerm'][$field . '_value'] );
                    ?>
                    <li><?php echo $display ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <?php __( 'None' ) ?>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?> 
    <?php endif; ?>
	</table><!-- /savings-detail-grid -->
  
  <?php if( !empty( $rebate['Incentive']['PublicNote'] ) ): ?>
      <?php $i = 0; ?>
      <?php foreach( $rebate['Incentive']['PublicNote'] as $note ): ?>
        <?php $classes = array( $i++ % 2 === 0 ? 'odd' : 'even' ) ?>
        <?php if( $i === 1 ): ?>
          <?php array_push( $classes, 'first' ) ?>
        <?php endif; ?>
        <?php if( $i === count( $rebate['Incentive']['PublicNote'] ) ): ?>
          <?php array_push( $classes, 'last' ) ?>
        <?php endif; ?>
        
        <p class="public-note <?php echo join( ' ', $classes ) ?>"><?php echo h( $note['note'] ) ?></p>
      <?php endforeach; ?>
  <?php endif; ?>
  
  <?php echo $this->Html->link( __( 'Get a Quote &rsaquo;', true ), array( 'controller' => 'proposals', 'action' => 'quote', h( $rebate['TechnologyIncentive']['id'] ), $location_id ), array( 'class' => 'quote-button', 'escape' => false ) ) ?>
  <?php echo $this->Html->link( 'Download the rebate form', $rebate['TechnologyIncentive']['rebate_link'] ) ?>
</div><!-- /modal popup -->
