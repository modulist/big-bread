<?php $this->set( 'title_for_layout', __( 'Ways to Save', true )) ?>

<h1 class="printable">Visit BigBread.net for the latest in personalized discounts and information</h1>

<?php echo $this->element( 'building_info', array( 'data' => $building ) ) ?>

<div id="contentbody">
  <?php if( !empty( $incentives ) ): ?>
    <?php foreach( $incentives as $group => $technology ): ?>
      <?php if( !empty( $technology_group_slug ) && strtolower( Inflector::slug( $group ) ) != $technology_group_slug ) {
          # If a group filter is applied, ignore other groups. All results
          # are still being returned so that we can pull the right numbers
          # for the rebate bar.
          # TODO: There's an opportunity for optimization here
          continue;
      } ?>
      
      <div id="info">
        <?php echo $this->Html->image( 'ico_' . strtolower( Inflector::slug( h( $group ) ) ) . '.png', array( 'alt' => h( $group ) ) ) ?>
        <h2 id="<?php echo strtolower( Inflector::slug( $group ) ) ?>"><?php echo !empty( $group ) ? h( $group ) : 'Unspecified Group' ?></h2>
      </div>
      
      <?php $technologies = array() ?>
      <?php foreach( $technology as $id => $details ): ?>
        <?php if( !in_array( $details['Technology']['name'], $technologies ) ): ?>
          <?php # Any products that have been entered for this building and this technology ?>
          <?php $products = Set::extract( '/Technology/Product/BuildingProduct/id', $details ) ?>
      
          <div id="item">
            <h3 id="<?php echo strtolower( Inflector::slug( h( $details['Technology']['name'] ), '' ) ) ?>"
                <?php if( !empty( $details['Technology']['GlossaryTerm']['definition'] ) ): ?>
                  class="help-available"
                  title="<?php echo $details['Technology']['GlossaryTerm']['definition'] ?>"
                <?php endif; ?>
            >My <?php echo h( $details['Technology']['name'] ) ?></h3>
            
            <?php if( empty( $products ) ): ?>
              <p><?php echo sprintf( __( 'No %s information has been entered.', true ), strtolower( Inflector::singularize( h( $details['Technology']['name'] ) ) ) ) ?></p>
            <?php else: ?>
              <?php foreach( $details['Technology']['Product'] as $product ): ?>
                <?php # Display the product if it's associated with a building ?>
                <?php if( !empty( $product['BuildingProduct'] ) ): ?>
                  <ul>
                    <li><?php __( 'Make' ) ?><br /><div><?php echo h( $product['make'] ) ?></div></li>
                    <li><?php __( 'Model' ) ?><br /><div><?php echo h( $product['model'] ) ?></div></li>
                    <li><?php __( 'Serial Number' ) ?><br />
                      <?php foreach( $product['BuildingProduct'] as $building_product ): ?>
                        <div><?php echo h( $building_product['serial_number'] ) ?></div>
                      <?php endforeach; ?>
                    </li>
                  </ul>
                  <div class="clear"></div>
                  <p>Product recall, safety &amp; warranty information coming soon.</p>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <div class="clear"></div>
          
          <?php /* ?>
          <div id="sponser">
            <h3>Sponsors</h3>
            <script type="text/javascript"><!--
              google_ad_client = "pub-8579999294251764";
              // Ways to Save, 468x60, created 4/18/11
              google_ad_slot   = "3280931539";
              google_ad_width  = 468;
              google_ad_height = 60;
              //-->
            </script>
            <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
            <div class="clear"></div>
          </div>
          <?php //*/ ?>
          
          <?php # Add the tech name to the stack so we don't print it again. ?>
          <?php array_push( $technologies, $details['Technology']['name'] ) ?>
        <?php endif; ?>
          
        <div class="itemprice_border" data-id="<?php echo $details['TechnologyIncentive']['id'] ?>">
          <div class="itemprice">
            <div class="price">
              <p class="pricevalue">
                <?php if( $details['IncentiveAmountType']['incentive_amount_type_id'] == 'PERC' ): ?>
                  <?php echo h( $details['TechnologyIncentive']['amount'] ) . h( $details['IncentiveAmountType']['name'] ) ?>
                <?php else: ?>
                  <?php echo '$' . h( $details['TechnologyIncentive']['amount'] ) ?>
                <?php endif; ?>
              </p>
              <?php if( !in_array( $details['IncentiveAmountType']['incentive_amount_type_id'], array( 'USD', 'PERC' ) ) ): ?>
                <p class="priceunit">(<?php echo h( $details['IncentiveAmountType']['name'] ) ?>)</p>
              <?php endif; ?>
            </div>
            <ul>
              <li class="itemname"><b><?php echo $details['Incentive']['name'] ?></b></li>
              <li><b><?php __( 'Expiration Date:' ) ?><br /><?php echo empty( $details['Incentive']['expiration_date'] ) ? __( 'When Funds Exhausted', true ) : date( 'm/d/Y', strtotime( $details['Incentive']['expiration_date'] ) ) ?></b></li>
            </ul>
          </div>
        </div>
        <div class="clear"></div>

        <div class="incentive">
          <?php if( !empty( $details['Incentive']['AdditionalIncentiveNote'] ) ): ?>
            <?php foreach( $details['Incentive']['AdditionalIncentiveNote'] as $note ): ?>
              <p><?php echo $note['note'] ?></p>
            <?php endforeach; ?>
          <?php endif; ?>
          
          <table class="incentive-details">
          <thead>
            <tr>
              <th>Technology</th>
              <th>Options</th>
              <th>Energy Source</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <?php echo h( $details['Technology']['name'] ) ?>
                <?php if( !empty( $details['TechnologyIncentive']['weblink'] ) ): ?>
                  <?php echo $this->Html->link( $this->Html->image( 'ico_web_link.gif', array( 'alt' => 'Sponsor link' ) ), $details['TechnologyIncentive']['weblink'], array( 'target' => '_blank', 'title' => 'Click here for more information regarding this rebate', 'escape' => false ) ) ?>
                <?php endif; ?>
                <?php if( !empty( $details['TechnologyIncentive']['rebate_link'] ) ): ?>
                  <?php echo $this->Html->link( $this->Html->image( 'ico_rebate_link.gif', array( 'alt' => 'Rebate link' ) ), $details['TechnologyIncentive']['rebate_link'], array( 'target' => '_blank', 'title' => 'Click here for rebate forms and processing', 'escape' => false ) ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if( !empty( $details['TechnologyOption'] ) ): ?>
                  <ul>
                    <?php foreach( $details['TechnologyOption'] as $option ): ?>
                      <li<?php echo !empty( $option['GlossaryTerm']['definition'] ) ? ' class="help-available" title="' . $option['GlossaryTerm']['definition'] . '"' : '' ?>><?php echo h( $option['name'] ) ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  None
                <?php endif; ?>
              </td>
              <td>
                <?php if( !empty( $details['EnergySource'] ) ): ?>
                  <ul>
                    <?php foreach( $details['EnergySource'] as $esource ): ?>
                      <li><?php echo h( $esource['name'] ) ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  None
                <?php endif; ?>
              </td>
            </tr>
          </tbody>
          </table>
          
          <?php if( !empty( $details['TechnologyTerm'] ) ): ?>
            <table class="incentive-tnc">
            <thead>
              <tr>
                <th class="terms"><?php __( 'Terms' ) ?></th>
                <th class="conditions"><?php __( 'Conditions' ) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach( $details['TechnologyTerm'] as $term ): ?>
              <tr>
                <td class="terms<?php echo !empty( $term['GlossaryTerm']['definition'] ) ? ' help-available' : '' ?>"<?php echo !empty( $term['GlossaryTerm']['definition'] ) ? ' title="' . $term['GlossaryTerm']['definition'] . '"' : '' ?>><?php echo h( $term['name'] ) ?></td>
                <td class="conditions">
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
                    None
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?> 
            <tbody>
            </table>
          <?php endif; ?>
          <?php if( !empty( $details['Incentive']['PublicNote'] ) ): ?>
            <h4>Notes</h4>
            <ul>
              <?php foreach( $details['Incentive']['PublicNote'] as $note ): ?>
                <li><?php echo $note['note'] ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          
          <p class="get-quote"><?php echo $this->Html->link( $this->Html->image( 'ico_get_quote.png' ), array( 'controller' => 'proposals', 'action' => 'request', $building['Building']['id'], $details['TechnologyIncentive']['id'] ), array( 'class' => 'dialog iframe', 'escape' => false ) ) ?></p>
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <div class="itemspac">
          <div class="incentive-note"><a href="#"><?php __( 'Show Details' ) ?></a></div>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div class="buttons">
  <div class="button">
    <input type="submit" value="Print Report" />
  </div>
</div>


