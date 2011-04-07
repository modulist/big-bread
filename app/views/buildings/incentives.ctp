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
    <?php foreach( $incentives as $group => $tech_incentives ): ?>
      <div id="info">
        <h2><?php echo !empty( $group ) ? $group : 'Unspecified Group' ?></h2>
      </div>
      
      <?php foreach( $tech_incentives as $id => $details ): ?>
        <?php # new PHPDump( $details, 'Details' ); ?>
        <div id="item">
          <ul>
            <li><?php echo h( $details['Technology']['name'] ) # echo $this->Html->image( 'T_AirCon.png', array( 'alt' => $details['Technology']['name'], 'title' => $details['Technology']['name'] ) ) ?></li>
            <li><?php __( 'Make' ) ?><br /><div>Abc</div></li>
            <li><?php __( 'Model' ) ?><br /><div>Abc123</div></li>
            <li><?php __( 'Serial Number' ) ?><br /><div>123456</div></li>
          </ul>
          <div class="clear"></div>
        </div>
    
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

        <div class="itemprice_border">
          <div class="itemprice">
            <div class="price USD"><p><?php echo h( $details['TechnologyIncentive']['amount'] ) ?></p></div>
            <ul>
              <li class="itemname"><b><?php echo h( $details['Incentive']['name'] ) ?></b></li>
              <li><b>Expiration Date<br /><?php echo empty( $details['Incentive']['expiration_date'] ) ? 'When Funds Exhausted' : date( 'm/d/Y', strtotime( $details['Incentive']['expiration_date'] ) ) ?></b></li>
            </ul>
          </div>
        </div>
        <div class="clear"></div>

        <div class="incentive">
          <div class="incentive-bar">
            <div class="incentive-btn">
              <a href="#" ><div id="TermsCondition_on">&nbsp;</div></a>
              <a href="#" ><div id="RebateForm_off">&nbsp;</div></a>
              <a href="#" ><div id="SponsorInfo_off">&nbsp;</div></a>
            </div>
            <h3>Incentives</h3>
            <div class="clear"></div>
          </div>

          <p>The total credil cannot exceed $1.200- must be installed on e taxp¤yer's principal residence in the United
          States Oulsque lacillsls eral a dui. Nam matesuada omnre dolor Cras gravida, dlem sit amet rhoncus ornare.
          erat ellt consectetuer eral, ld egestes pede nlbh eget odlo. Proln nsequat rutrum. Nullam egestas leuglat lelis.
          Integer edipiscing semper Iigula. Nunc molestie. nist sit amet cursus convallls. sapien lectus enim wisi id lectus
          Donec vestibulum. Etiam vel nlbhr Nutla lacillsl. Mauris ptiaretra. Donec sugue Fusce ultrlces, neque ld dignisslm
          ullrices. tellus mauris dictum elit. vel leclnie enim metus eu nunc.</p>
        </div>
        <div class="clear"></div>
        
        <div class="itemspac">
          <div class="incentive-note"><a href="#" >Incentive Notes</a></div>
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


