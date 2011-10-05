<?php $this->set( 'title_for_layout', __( 'Ways to Save', true )) ?>

<!-- Used by the address list in the sidebar -->
<?php echo $this->Html->script( 'jquery/jquery.cycle.all.min.js', array( 'inline' => false ) ) ?>

<h1 class="printable"><?php __( 'Visit SaveBigBread.com for the latest in personalized discounts and information' ) ?></h1>

<!-- my location html has been added to /app/views/elements/building_info.ctp to replace #contentheader -->
<?php echo $this->element( 'building_info', array( 'data' => $building ) ) ?>


<!-- start new html code for rebates table -->
<div id="my-rebates" class="grid_9">
<h2>Rebates for Main House</h2>
	<table class="rebates-watch-list">
  	<!-- air conditioner -->
    <tbody>
      <tr class="rebate-category-row first">
        <td class="rebate-category">
          <table class="rebate-header">
            <tr>
              <td class="rebate-description">
                <a href="#" class="expanded"><span class="rebate-category-title">Air conditioners</span> (5)</a>
                <a href="#" class="star" title="click to remove">&nbsp;&nbsp;</a>
              </td>
              <td class="rebate-amount">$6,130</td>
              <td class="rebate-total">total</td>
            </tr>
          </table>
          <table class="rebate-content">
            <tr class="first odd">
              <td class="rebate-description">
                <a href="#">Florida Power and Light -<br /> Residential Energy Efficiency Program</a>
                <a href="#" class="details">details �</a>
              </td>
              <td class="rebate-dates">while funds last</td>
              <td class="rebate-amount">$1,930</td>
              <td class="rebate-action">
                <a href="#" class="quote-button">GET A QUOTE &rsaquo;</a>
                <!--<a href="#" class="details-button">DETAILS &rsaquo;</a>-->
              </td>
            </tr>
            <tr class="even">
              <td class="rebate-description">
                <a href="#">Lennox HVAC Promotions</a>
                <a href="#" class="details">details �</a>
              </td>
              <td class="rebate-dates">through <span class="date nowrap">08/26/2011</span></td>
              <td class="rebate-amount">$1,200</td>
              <td class="rebate-action">
                <a href="#" class="quote-button">GET A QUOTE &rsaquo;</a>
                <!--<a href="#" class="details-button">DETAILS &rsaquo;</a>-->
              </td>
            </tr>
            <tr class="odd">
              <td class="rebate-description">
                <a href="#">Carrier Infinity Series HVAC Rebates</a>
                <a href="#" class="details">details �</a>
              </td>
              <td class="rebate-dates">through <span class="date nowrap">08/31/2011</span></td>
              <td class="rebate-amount">$1,000</td>
              <td class="rebate-action">
                <a href="#" class="quote-button">GET A QUOTE &rsaquo;</a>
               <!--<a href="#" class="details-button">DETAILS &rsaquo;</a>-->
               </td>
            </tr>
            <tr class="even">
              <td class="rebate-description">
                <a href="#">2011 Rheem HVAC Consumer CashBack Promotion</a>
                <a href="#" class="details">details �</a>
              </td>
              <td class="rebate-dates">through <span class="date nowrap">11/15/2011</span></td>
              <td class="rebate-amount">$1,000</td>
              <td class="rebate-action">
                <a href="#" class="quote-button">GET A QUOTE &rsaquo;</a>
                <!--<a href="#" class="details-button">DETAILS &rsaquo;</a>-->
              </td>
            </tr>
            <tr class="last odd">
              <td class="rebate-description">
                <a href="#">Trane HVAC Promotions</a>
                <a href="#" class="details">details �</a>
              </td>
              <td class="rebate-dates">through <span class="date nowrap">08/15/2011</span></td>
              <td class="rebate-amount">$1,000</td>
              <td class="rebate-action">
                <a href="#" class="quote-button">GET A QUOTE &rsaquo;</a>
                <!--<a href="#" class="details-button">DETAILS &rsaquo;</a>-->
              </td>
            </tr>
          </table>      
        </td>
      </tr>
  
      <!-- dishwashers -->
       <tr class="rebate-category-row">
        <td class="rebate-category">
          <table class="rebate-header">
            <tr>
              <td class="rebate-description">
                <a href="#" class="expanded"><span class="rebate-category-title">Dishwashers</span> (2)</a>
                <a href="#" class="star" title="click to remove">&nbsp;&nbsp;</a>
              </td>
              <td class="rebate-amount">$100</td>
              <td class="rebate-total">total</td>
            </tr>
          </table>
          <table class="rebate-content">
            <tr class="first odd">
              <td class="rebate-description">
                <a href="#">GE Caf&eacute; Series Appliance Rebates</a>
              </td>
              <td class="rebate-dates">through 10/02/2011</td>
              <td class="rebate-amount">$50</td>
              <td class="rebate-action">
                <a href="#" class="details-button">DETAILS &rsaquo;</a>
              </td>
            </tr>
            <tr class="last even">
              <td class="rebate-description">
                <a href="#">GE Profile Series Appliance Rebates</a>
              </td>
              <td class="rebate-dates">through 10/02/2011</td>
              <td class="rebate-amount">$50</td>
              <td class="rebate-action">
                <a href="#" class="details-button">DETAILS &rsaquo;</a>
              </td>
            </tr>
          </table>      
        </td>
      </tr>

      
      <!-- freezers -->
       <tr class="rebate-category-row last">
        <td class="rebate-category">
          <table class="rebate-header">
            <tr>
              <td class="rebate-description">
                <a href="#" class="expanded"><span class="rebate-category-title">Freezers</span> (1)</a>
                <a href="#" class="star" title="click to remove">&nbsp;&nbsp;</a>
              </td>
              <td class="rebate-amount">$500</td>
              <td class="rebate-total">total</td>
            </tr>
          </table>
          <table class="rebate-content">
            <tr class="first odd">
              <td class="rebate-description">
                <a href="#">Viking Special Promotions</a>
              </td>
              <td class="rebate-dates">through 09/30/2011</td>
              <td class="rebate-amount">$500</td>
              <td class="rebate-action">
                <a href="#" class="details-button">DETAILS &rsaquo;</a>
              </td>
            </tr>
          </table>      
        </td>
      </tr>
	  </tbody>
  </table>
</div> <!-- #My rebates -->

<!-- end new html code for rebates table -->

<!-- start legacy code -->
<div id="contentbody">
  <?php if( !empty( $incentives ) ) { ?>
    <?php foreach( $incentives as $group => $technology ) { ?>
      <?php if( !empty( $technology_group_slug ) && strtolower( Inflector::slug( $group ) ) != $technology_group_slug ) {
          # If a group filter is applied, ignore other groups. All results
          # are still being returned so that we can pull the right numbers
          # for the rebate bar.
          # TODO: There's an opportunity for optimization here
          continue;
      } ?>
<div class="technology-group <?php echo strtolower( Inflector::slug( $group ) ) ?>">
          <div id="info">
            <?php echo $this->Html->image( 'ico_' . strtolower( Inflector::slug( h( $group ) ) ) . '.png', array( 'alt' => h( $group ) ) ) ?>
            <h2 id="<?php echo strtolower( Inflector::slug( $group ) ) ?>"><?php echo !empty( $group ) ? h( $group ) : 'Unspecified Group' ?></h2>
          </div><!-- #info -->
      
        <?php $technologies = array() ?>
        <?php foreach( $technology as $id => $details ) { ?>
          <?php $technology_slug = strtolower( Inflector::slug( h( $details['Technology']['name'] ), '' ) ); ?>
          
          <?php if( !in_array( $details['Technology']['name'], $technologies ) ) { ?>
            <?php # Any products that have been entered for this building and this technology ?>
            <?php $products = Set::extract( '/Technology/Product/BuildingProduct/id', $details ) ?>
        
            <div class="item <?php echo $technology_slug ?>">
              <h3 id="<?php echo strtolower( Inflector::slug( h( $details['Technology']['name'] ), '' ) ) ?>"
                  <?php if( !empty( $details['Technology']['GlossaryTerm']['definition'] ) ) { ?>
                    class="help-available"
                    title="<?php echo $details['Technology']['GlossaryTerm']['definition'] ?>"
                  <?php } ?>
              >My <?php echo h( $details['Technology']['name'] ) ?><?php echo $this->Html->link( __( 'Expand all incentive details', true ), '#', array( 'class' => 'all-incentives' ) ) ?></h3>
              
              <?php if( empty( $products ) ) { ?>
                <p><?php echo sprintf( __( 'No %s information has been entered.', true ), strtolower( Inflector::singularize( h( $details['Technology']['name'] ) ) ) ) ?></p>
              <?php } else { ?>
                <?php foreach( $details['Technology']['Product'] as $product ) { ?>
                  <?php # Display the product if it's associated with a building ?>
                  <?php foreach( $product['BuildingProduct'] as $existing_equipment ) { ?>
                    <ul>
                      <li><?php __( 'Make' ) ?><br /><div><?php echo h( $product['make'] ) ?></div></li>
                      <li><?php __( 'Model' ) ?><br /><div><?php echo h( $product['model'] ) ?></div></li>
                      <li class="last"><?php __( 'Serial Number' ) ?><br /><div><?php echo h( $existing_equipment['serial_number'] ) ?></div></li>
                    </ul>
                    <div class="clear"></div>
                    <p>Product recall, safety &amp; warranty information coming soon.</p>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            </div><!-- .item -->
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
          <?php } ?>
            
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
              </div> <!-- .price -->
              <ul>
                <li class="itemname"><b><?php echo $details['Incentive']['name'] ?></b></li>
                <li><b><?php __( 'Expiration Date:' ) ?><br /><?php echo empty( $details['Incentive']['expiration_date'] ) ? __( 'When Funds Exhausted', true ) : date( 'm/d/Y', strtotime( $details['Incentive']['expiration_date'] ) ) ?></b></li>
              </ul>
            </div><!-- .itemprice -->
          </div><!-- .itemprice_border -->
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
              </tbody>
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
            
            <p class="get-quote"><?php echo $this->Html->link( $this->Html->image( 'ico_get_quote.png' ), array( 'controller' => 'proposals', 'action' => 'request', $building['Building']['id'], $details['TechnologyIncentive']['id'] ), array( 'class' => 'dialog iframe', 'title' => 'We\'ll get you proposals from contractors who are eligible to provide manufacturer and utility rebates that maximize your savings.', 'escape' => false ) ) ?></p>
            <div class="clear"></div>
          </div><!-- .incentive -->
          <div class="clear"></div>
            
          <div class="itemspac ">
            <div class="incentive-note <?php echo $technology_slug ?>"><a href="#"><?php __( 'Show Details' ) ?></a></div>
          </div><!-- .itemspac -->
        <?php } ?>
</div><!-- .technology-group -->
    <?php } ?>
  <?php } ?>
</div> <!-- #contentbody -->

<div class="buttons">
  <div class="button">
    <input type="submit" value="Print Report" />
  </div>
</div>
<!-- end legacy code -->

