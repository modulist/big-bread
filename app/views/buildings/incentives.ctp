<?php $this->set( 'title_for_layout', __( 'Incentives', true )) ?>

<div id="contentheader">
  <h3><?php __( 'House Information' ) ?></h3>
  <div id="house_img">
    <?php echo $this->Html->image( '1b_60.png', array( 'title' => 'My House' ) ) ?>
  </div>
  <div id="house_info">
    <p><b>
      <?php echo h( $building['Address']['address_1'] ) ?><br />
      <?php if( !empty( $building['Address']['address_2'] ) ): ?>
        <?php echo h( $building['Address']['address_2'] ) ?><br />
      <?php endif; ?>
      <?php echo h( $building['Address']['ZipCode']['city'] ) . ', ' . h( $building['Address']['ZipCode']['state'] ) . ' ' . h( $building['Address']['zip_code'] ) ?><br />
    </b></p>
    <br />
    <ul>
      <li><b>Client</b> | <?php echo h( $building['Client']['full_name'] ) ?> | <?php echo $this->Html->link( $building['Client']['email'], 'mailto:' . $building['Client']['email'] ) ?></li>
      <li><b>Realtor</b> | <?php echo h( $building['Realtor']['full_name'] ) ?> | <?php echo $this->Html->link( $building['Realtor']['email'], 'mailto:' . $building['Realtor']['email'] ) ?></li>
      <li><b>Inspector</b> | <?php echo h( $building['Inspector']['full_name'] ) ?> | <?php echo $this->Html->link( $building['Inspector']['email'], 'mailto:' . $building['Inspector']['email'] ) ?></li>
    </ul>
  </div>
  <div class="clear"></div>
</div>

<div id="contentbody">
  <?php if( !empty( $incentives ) ): ?>
    <?php foreach( $incentives as $group => $technology ): ?>
      <div id="info">
        <h2><?php echo !empty( $group ) ? h( $group ) : 'Unspecified Group' ?></h2>
      </div>
      
      <?php $technologies = array() ?>
      <?php foreach( $technology as $id => $details ): ?>
        <?php if( !in_array( $details['Technology']['name'], $technologies ) ): ?>
          <?php if( empty( $details['Technology']['Product'] ) ): ?>
            <div id="item">
              <ul>
                <li><div><?php echo h( $details['Technology']['name'] ) ?></div></li>
                <li><div><?php echo sprintf( __( 'No existing %s', true ), strtolower( Inflector::pluralize( h( $details['Technology']['name'] ) ) ) ) ?></div></li>
              </ul>
              <div class="clear"></div>
            </div>
          <?php else: ?>
            <?php foreach( $details['Technology']['Product'] as $product ): ?>
              <div id="item">
                <ul>
                  <li><div><?php echo h( $details['Technology']['name'] ) ?></div></li>
                  <li><?php __( 'Make' ) ?><br /><div><?php echo h( $product['make'] ) ?></div></li>
                  <li><?php __( 'Model' ) ?><br /><div><?php echo h( $product['model'] ) ?></div></li>
                  <li><?php __( 'Serial Number' ) ?><br />
                    <?php foreach( $product['BuildingProduct'] as $building_product ): ?>
                      <div><?php echo h( $building_product['serial_number'] ) ?></div>
                    <?php endforeach; ?>
                  </li>
                </ul>
                <div class="clear"></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          
          <div id="sponser">
            <h3>Sponsors</h3>
            <ul>
              <li><b>American Home Shield</b>-Avoid Costly Home A/C Repairs.<br />
                    Get A Home Warranty Quote Free!<br />
                    <a href="#">homewarranty.ahs.com</a>
              </li>
              <li><b>Virginia Repair AC</b>-Find Prescreened Cooling Pros Free!<br />
                    Repair, Replace &amp; Service Your A/C.<br />
                    <a href="#">www.servicemagic.com</a>
              </li>
              <li><b>Windsor, VA HVAC Services</b>-Local, Quality Heating &amp; AC Service<br />
                  Serving Windsor &amp; Surrounding Areas<br />
                  <a href="#">www.tidewaterpetro.com/HVAC</a>
              </li>
            </ul>
            <div class="clear"></div>
          </div>
          
          <?php # Add the tech name to the stack so we don't print it again. ?>
          <?php array_push( $technologies, $details['Technology']['name'] ) ?>
        <?php endif; ?>

        <div class="itemprice_border">
          <div class="itemprice">
            <div class="price <?php echo Inflector::slug( h( $details['TechnologyIncentive']['incentive_amount_type_id'] ) ) ?>">
              <p><?php echo h( $details['TechnologyIncentive']['amount'] ) ?></p>
            </div>
            <ul>
              <li class="itemname"><b><?php echo h( $details['Incentive']['name'] ) ?></b></li>
              <li><b><?php __( 'Expiration Date:' ) ?><br /><?php echo empty( $details['Incentive']['expiration_date'] ) ? __( 'When Funds Exhausted', true ) : date( 'm/d/Y', strtotime( $details['Incentive']['expiration_date'] ) ) ?></b></li>
            </ul>
          </div>
        </div>
        <div class="clear"></div>

        <div class="incentive">
          <?php if( !empty( $details['Incentive']['AdditionalIncentiveNote'] ) ): ?>
            <?php foreach( $details['Incentive']['AdditionalIncentiveNote'] as $note ): ?>
              <p><?php echo h( $note['note'] ) ?></p>
            <?php endforeach; ?>
          <?php endif; ?>
          
          <table cellspacing="0" border="1" class="incentive-details">
          <thead>
            <tr>
              <th>Technology</th>
              <th>Options</th>
              <th>Energy Source</th>
            </tr>
          <thead>
          <tbody>
            <td><?php echo h( $details['Technology']['name'] ) ?></td>
            <td>
              <?php if( !empty( $details['TechnologyOption'] ) ): ?>
                <ul>
                  <?php foreach( $details['TechnologyOption'] as $option ): ?>
                    <li><?php echo h( $option['name'] ) ?></li>
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
            <td>
          </tbody>
          </table>
          
          <?php if( !empty( $details['TechnologyTerm'] ) ): ?>
            <table cellspacing="0" class="incentive-tnc" border="1">
            <thead>
              <tr>
                <th class="terms"><?php __( 'Terms' ) ?></th>
                <th class="conditions"><?php __( 'Conditions' ) ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach( $details['TechnologyTerm'] as $term ): ?>
              <tr>
                <td class="terms"><?php echo h( $term['name'] ) ?></td>
                <td class="conditions">
                  <?php if( !empty( $term['field1_name'] ) || !empty( $term['field2_name'] ) ): ?>
                    <ul>
                      <?php foreach( array( 'field1', 'field2' ) as $i => $field ): ?>
                        <li><?php echo h( $term[$field . '_name'] ) . h( $term['IncentiveTechTerm'][$field . '_value'] ) ?></li>
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
                <li><?php echo h( $note['note'] ) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
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


