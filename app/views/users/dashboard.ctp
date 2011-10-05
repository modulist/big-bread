<?php if( !$has_locations ): ?>
  <?php echo $this->element( '../buildings/_form', array( 'short' => true ) ) ?>
<?php endif; ?>

<div id="messages" class="grid_9">
	<h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
	<p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?></p>
</div><!-- /#messages -->

<div id="my-locations" class="grid_9">
	<div class="clearfix">
		<a href="#" class="add-location-button">Add a location &rsaquo;</a>
		<h2>My locations:</h2>
	</div>
	<div class="location-wrapper clearfix">
		<div class="location-icon">1</div>
		<h4>Main House</h4>
		<div class="location-address">
			<p>12841 SW 70th Avenue<br />
			Miami, FL 33156</p>
			<a href="#" class="edit-location-button">Edit</a>
		</div>
		<div class="location-equipment-grid grid_5">
			<table class="location-equipment">
				<tr class="first odd">
					<td class="model-name"><a href="#">Kenmore washer</a></td>
					<td class="model-number"><a href="#">110.27087601</a></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
				<tr class="even">
					<td class="model-name"><a href="#">Kenmore dryer</a></td>
					<td class="model-number"><a href="#">110.67087600</a></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
				<tr class="last odd">
					<td class="model-name"><a href="#">Kenmore washer</a></td>
					<td class="model-number"></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
			</table>
			<a class="add-equipment-button" href="#">Add equipment</a>
		</div><!-- /location-equipment-grid -->
	</div><!-- /location-wrapper -->

</div><!-- /my-locations -->


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
                <a href="#" class="details">details Ý</a>
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
                <a href="#" class="details">details Ý</a>
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
                <a href="#" class="details">details Ý</a>
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
                <a href="#" class="details">details Ý</a>
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
                <a href="#" class="details">details Ý</a>
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


<div id="pending-quotes" class="grid_9">
	<h2>Pending Quotes for Main House</h2>
  <table class="pending-quotes">
  	<tr class="first odd">
    	<td class="quote-category">Building Shell > Windows</td>
    	<td class="quote-date">1 week ago</td>
    	<td class="quote-status">Active</td>
    	<td class="quote-action"><a href="#" class="remove-button">remove</a></td>
		</tr>      
  	<tr class="even">
    	<td class="quote-category">Heating and Cooling > Air Conditioners</td>
    	<td class="quote-date">3 weeks 2 days ago</td>
    	<td class="quote-status">Active</td>
    	<td class="quote-action"><a href="#" class="remove-button">remove</a></td>
		</tr>      
  	<tr class="last odd">
    	<td class="quote-category">Heating and Cooling > Air Conditioners</td>
    	<td class="quote-date">3 months 11 days ago</td>
    	<td class="quote-status">Closed</td>
    	<td class="quote-action"><a href="#" class="remove-button">remove</a></td>
		</tr>      
  </table>

</div>


<div id="my-interests" class="grid_9">
	<h2>My Interests for Main House</h2>
  <p class="instructions">
  	Select as many categories of rebates as you like by clicking on the stars below. 
  </p>
	<div class="my-interests-grid clearfix">
  	<div class="column-first grid_3">
    	<h4>Heating and Cooling</h4>
      <ul>
      	<li class="active"><a href="#">Air conditioner</a></li>
      	<li><a href="#">Boiler</a></li>
      	<li><a href="#">Furnace</a></li>
      	<li><a href="#">Heat Pump</a></li>
      	<li><a href="#">Space heaters</a></li>
      	<li><a href="#">Ducts</a></li>
      </ul>
      <h4>Building shell</h4>
      <ul>
      	<li><a href="#">Windows</a></li>
      	<li><a href="#">Doors</a></li>
      	<li><a href="#">Roof</a></li>
      </ul>
    </div>
  	<div class="column-middle grid_3">
    	<h4>Kitchen</h4>
      <ul>
      	<li><a href="#">Refrigerator</a></li>
      	<li class="active"><a href="#">Freezer</a></li>
      	<li><a href="#">Range/cooktop/oven</a></li>
      	<li class="active"><a href="#">Dishwasher</a></li>
      </ul>
    	<h4>Laundry</h4>
      <ul>
      	<li><a href="#">Washer</a></li>
      	<li><a href="#">Dryer</a></li>
      </ul>
    </div>
  	<div class="column-last grid_3">
    	<h4>Hot Water</h4>
      <ul>
      	<li><a href="#">Water heater</a></li>
      	<li><a href="#">Solar water heater</a></li>
      </ul>
    	<h4>Lighting</h4>
      <ul>
      	<li><a href="#">Light bulbs</a></li>
      	<li><a href="#">Light fixtures</a></li>
      </ul>
    </div>
  </div>
</div>

